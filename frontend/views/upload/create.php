<?php

use yii\helpers\Html;
use yii\bootstrap\Progress;
use yii\widgets\ActiveForm;
use common\assets\UploadFileAsset;
use yii\helpers\Url;

//UploadFileAsset::register($this);


/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileBase */

$this->title = Yii::t('app', 'Upload Fota Package');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Progress::widget([
      'percent' => 0,
      'barOptions' => ['class' => 'progress-bar-success', 'id'=> 'progress'],
      'options' => [
          'class' => 'active progress-striped',
          'style' => 'display: none',
      ],
    ]); ?>

    <?php $form = ActiveForm::begin(['options' => ['style' => "display: block"]]); ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Upload'), ['class' => 'btn btn-success', 'id' => 'upload']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>

<?php
$targetUrl = Url::toRoute([$this->context->id . '/upload']);
$finishedUrl = Url::toRoute([$this->context->id . '/index']);
$js = <<<JS
/*
    const LENGTH = 1024 * 1024;

    function send(curBlobNum) {
        var file = $("#fotapackageupload-file").get(0).files[0];
        var start = curBlobNum*LENGTH;
        var end = (curBlobNum + 1)*LENGTH;
        var blob = file.slice(start, end);
        var meta = $('meta[name="csrf-token"]').attr("content");
        var totalBlobNum = Math.ceil(file.size / LENGTH);
        var fileName = file.name;

        var param = {};
        param["blob"] = blob;
        param["curBlobNum"] = curBlobNum;
        param["totalBlobNum"] = totalBlobNum;
        param["fb_name"] = fileName;
        param["_csrf"] = meta;

        $.ajax({
            async: true,
            type : 'post',
            cache: false,
            url: '$targetUrl',
            processData: false,
            //contentType: false,
            data: {"blob": blob, "curBlobNum": curBlobNum, "totalBlobNum": totalBlobNum, "fb_name": fileName, "_csrf": meta},
            success : function(data) {
                var obj = JSON.parse(data);
                var finish = obj.finish;
                if (finish !== true) {
                    var curBlobNum = obj.curBlobNum;
                    send(curBlobNum);
                } else {
                   // $(window).attr('location', '$finishedUrl');
                }
            }
        });
    }
*/

    var upload = new Upload();

    function Upload() {
        
        const LENGTH = 1024 * 1024;
        var start = 0;
        var blob;
        var is_stop = 0
        var total_blob_num = 1;
        var progressObj;

        function init(file, bStart) {
            if (File) {
                total_blob_num = Math.ceil(file.size / LENGTH);
            } else {
                total_blob_num = 1;
            }
            start = 0;

            progressObj = document.getElementById('progress');
            var w0 = document.getElementById('w0');
            var w1 = document.getElementById('w1');

            if (bStart === true) {
                w0.style.display = "block";
                w1.style.display = "none"
            } else {
                w0.style.display = "none"
                w1.style.display = "block";
                progressObj.style.width = '0%';
            }
        }

        //对外方法，传入文件对象
        this.addFileAndSend = function(that) {
            var file = that.files[0];
            init(file, true);
            sendFile(file);
        }

        //切割文件
        function cutFile(file) {
            var file_blob = file.slice(start,start + LENGTH);
            start += LENGTH;
            return file_blob;
        };

        //显示进度
        function showProgress(blob_num) {
            var progress;
            if(total_blob_num == 1) {
                progress = '100%';
            } else {
                progress = Math.min(100,(blob_num/total_blob_num)* 100 ) +'%';
            }
            progressObj.style.width = progress;
        }

        //发送文件
        function sendFile(file) {
            var xhr = new XMLHttpRequest();
            var form_data = new FormData();

            var meta = $('meta[name="csrf-token"]').attr("content");
            blob = cutFile(file);
            var blob_num = Math.ceil(start / LENGTH); // begin from 1
            
            form_data.append('_csrf-frontend', meta);
            form_data.append('fb_name', file.name);
            form_data.append('totalBlobNum', total_blob_num);
            form_data.append('curBlobNum', blob_num);
            form_data.append('blob', blob);
 
            xhr.open('POST', '$targetUrl', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showProgress(blob_num);

                    if (start < file.size && is_stop === 0) {
                        sendFile(file);
                    } else {
                        init(file, false);
                    }
                    //setTimeout("saveUserInfo()", 1000);
                /*
                    var t = setTimeout(function() {
                        if (start < file.size && is_stop === 0) {
                            sendFile(file);
                        } else {
                            setTimeout(t);
                        }
                    },1000);
                */
                } else {
                    //alert("send error!");
                }
            }
            xhr.send(form_data);
        }
    }

    $('#upload').click(function(e) {
        //send(0); 
        upload.addFileAndSend($("#fotapackageupload-file").get(0));
    });
JS;
    $this->registerJs($js);
?>

