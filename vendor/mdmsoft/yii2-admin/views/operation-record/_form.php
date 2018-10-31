<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OperationRecord\OperationRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'or_u_id')->textInput() ?>

    <?= $form->field($model, 'or_table_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'or_table_item_id')->textInput() ?>

    <?= $form->field($model, 'or_table_item_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'or_table_action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'or_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
