<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\publish\SoftwarePublish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-publish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sp_id')->textInput() ?>

    <?= $form->field($model, 'sp_sw_id')->textInput() ?>

    <?= $form->field($model, 'sp_file_count')->textInput() ?>

    <?= $form->field($model, 'sp_date')->textInput() ?>

    <?= $form->field($model, 'sp_publisher')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
