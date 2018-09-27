<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileBase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-base-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fb_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fb_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fb_status')->textInput() ?>

    <?= $form->field($model, 'fb_date')->textInput() ?>

    <?= $form->field($model, 'fb_size')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
