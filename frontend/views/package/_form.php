<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-extend-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'imageFile')->fileInput()->hint($model->fb_name) ?>

    <?= $form->field($model, 'fe_from_ver')->dropDownList(ArrayHelper::map($model->versionList,'sw_id', 'sw_ver')) ?>

    <?= $form->field($model, 'fe_to_ver')->dropDownList(ArrayHelper::map($model->versionList,'sw_id', 'sw_ver')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
