<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-extend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fe_fb_id')->textInput() ?>

    <?= $form->field($model, 'fe_from_ver')->textInput() ?>

    <?= $form->field($model, 'fe_to_ver')->textInput() ?>

    <?= $form->field($model, 'fe_checksum')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
