<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\fotaSrc\ReleaseNoteLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */

$this->title = Yii::t('app', 'Update File Extend: ' . $model->fb_name, [
    'nameAttribute' => '' . $model->fb_name,
]);

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->fe_id, 'url' => ['view', 'id' => $model->fe_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="file-extend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="file-extend-form">

        <?php 
        $languageList = ReleaseNoteLanguage::find()->all();
        ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'fb_name')->textInput(['value' => $model->fb_name, 'readonly' => 'readonly']) ?>

        <?= $form->field($model, 'sourceVersion')->textInput(['value' => $model->sourceVersion, 'readonly' => 'readonly']) ?>

        <?= $form->field($model, 'targetVersion')->textInput(['value' => $model->targetVersion, 'readonly' => 'readonly']) ?>

        <?= $form->field($model, 'fe_expiration_date')->textInput(['value' => $model->fe_expiration_date, 'readonly' => 'readonly']) ?>

        <?= $form->field($model, 'fe_release_note')->textarea(['value' => $model->fe_release_note, 'readonly' => 'readonly']) ?>

        <?= $form->field($model, 'language')->dropDownList(ArrayHelper::map($languageList, 'rnl_tag', 'rnl_note')) ?>

        <?= $form->field($model, 'langNote')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$js = <<<JS
    var note = {};

    $('#fileextend-langnote').bind('input propertychange', function() {
        var tag = $('select#fileextend-language option:selected').val();
        var value = $("#fileextend-langnote")[0].value;
        note[tag] = value;
        var noteStr = "";
        $.each(note,function(key, value){
            noteStr = noteStr + "<" + key + ">"
                              + value 
                              + "</" + key + ">\\n";
        });
        $("#fileextend-fe_release_note")[0].value = noteStr;
    });

    $('#fileextend-language').change(function() {
        var tag = $('select#fileextend-language option:selected').val();
        if (tag in note) {
            $("#fileextend-langnote")[0].value = note[tag];
        } else {
            $("#fileextend-langnote")[0].value = '';
        }
    });
JS;
    $this->registerJs($js);
?>
