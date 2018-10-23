<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Progress;
use yii\widgets\ActiveForm;
use common\assets\UploadFileAsset;
use yii\helpers\Url;
use frontend\models\software\Software;
use frontend\models\fotaSrc\ReleaseNoteLanguage;
use kartik\datetime\DateTimePickerAsset;
use kartik\datetime\DateTimePicker;

DateTimePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */

$this->title = Yii::t('app', 'Create File Extend');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-extend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Progress::widget([
      'percent' => 0,
      'barOptions' => ['class' => 'progress-bar-success', 'id'=> 'progress'],
      'options' => [
          'class' => 'active progress-striped',
          'style' => 'display: none',
      ],
    ]); ?>

    <div class="file-extend-form">

        <?php 
        $puidId = Yii::$app->user->getUserCache('puidId');
        $versionList = Software::find()->where(['sw_puid' => $puidId])->all();
        $languageList = ReleaseNoteLanguage::find()->all();
        ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <?= $form->field($model, 'fromVersion')->dropDownList(ArrayHelper::map($versionList, 'sw_id', 'sw_ver')) ?>

        <?= $form->field($model, 'toVersion')->dropDownList(ArrayHelper::map($versionList, 'sw_id', 'sw_ver')) ?>

        <?= $form->field($model, 'expireDate')->widget(DateTimePicker::classname(), [
                                                           'options' => ['placeholder' => ''],
                                                           'pluginOptions' => [
                                                               'autoclose' => true,
                                                               'format' => "yyyy-mm-dd",
                                                               'minView' => "month", // 只选择日期，不选择时间
                                                           ],
                                                           'pluginName' => 'datetimepicker',
                                                        ]
        )?>

        <?= $form->field($model, 'releaseNote')->textarea(['value' => $model->releaseNote]) ?>

        <?= $form->field($model, 'language')->dropDownList(ArrayHelper::map($languageList, 'rnl_id', 'rnl_name')) ?>

        <?= $form->field($model, 'langNote')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$targetUrl = Url::toRoute([$this->context->id . '/upload']);
$finishedUrl = Url::toRoute([$this->context->id . '/index']);
$js = <<<JS
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
            var sourceDroplist = $("#fotapackageupload-fromversion")[0];
            var sourceVersion = sourceDroplist.options[sourceDroplist.selectedIndex].value;   
            var targetDroplist = $("#fotapackageupload-toversion")[0];
            var targetVersion = targetDroplist.options[targetDroplist.selectedIndex].value;
            var expireDate = $("#fotapackageupload-expiredate")[0].value;
            var releaseNote = $("#fotapackageupload-releasenote")[0].value;

            form_data.append('_csrf-frontend', meta);
            form_data.append('fromVersion', sourceVersion);
            form_data.append('toVersion', targetVersion);
            form_data.append('expireDate', expireDate);
            form_data.append('fb_name', file.name);
            form_data.append('totalBlobNum', total_blob_num);
            form_data.append('curBlobNum', blob_num);
            form_data.append('releaseNote', releaseNote);
            form_data.append('blob', blob);
 
            xhr.open('POST', '$targetUrl', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showProgress(blob_num);

                    if (start < file.size && is_stop === 0) {
                        sendFile(file);
                    } else {
                        init(file, false);
                        window.location.href = "$finishedUrl";
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

    $('#w1').on('beforeSubmit', function(e) {
        var validated = $('#w1').yiiActiveForm('data').validated;
        if (validated) {
            upload.addFileAndSend($("#fotapackageupload-file").get(0));
        } else {
            alert('some field is going wrong.');
        }
        return false;
    });
JS;
    $this->registerJs($js);
?>
