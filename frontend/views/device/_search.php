<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\DeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'd_id') ?>

    <?= $form->field($model, 'd_code') ?>

    <?= $form->field($model, 'd_dg_id') ?>

    <?= $form->field($model, 'd_bind_ver') ?>

    <?= $form->field($model, 'd_date') ?>

    <?php // echo $form->field($model, 'd_u_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
