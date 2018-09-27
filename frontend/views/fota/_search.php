<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FotaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-extend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fe_id') ?>

    <?= $form->field($model, 'fe_fb_id') ?>

    <?= $form->field($model, 'fe_from_ver') ?>

    <?= $form->field($model, 'fe_to_ver') ?>

    <?= $form->field($model, 'fe_checksum') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
