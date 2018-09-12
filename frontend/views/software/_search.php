<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\software\SoftwareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sw_id') ?>

    <?= $form->field($model, 'sw_ver') ?>

    <?= $form->field($model, 'sw_creator') ?>

    <?= $form->field($model, 'sw_expiration_date') ?>

    <?= $form->field($model, 'sw_release_note') ?>

    <?php // echo $form->field($model, 'sw_date') ?>

    <?php // echo $form->field($model, 'sw_puid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
