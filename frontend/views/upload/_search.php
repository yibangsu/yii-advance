<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileBaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-base-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fb_id') ?>

    <?= $form->field($model, 'fb_name') ?>

    <?= $form->field($model, 'fb_path') ?>

    <?= $form->field($model, 'fb_status') ?>

    <?= $form->field($model, 'fb_date') ?>

    <?php // echo $form->field($model, 'fb_size') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
