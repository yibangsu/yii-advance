<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OperationRecord\OperationRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'or_id') ?>

    <?= $form->field($model, 'or_u_id') ?>

    <?= $form->field($model, 'or_table_name') ?>

    <?= $form->field($model, 'or_table_item_id') ?>

    <?= $form->field($model, 'or_table_item_name') ?>

    <?php // echo $form->field($model, 'or_table_action') ?>

    <?php // echo $form->field($model, 'or_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
