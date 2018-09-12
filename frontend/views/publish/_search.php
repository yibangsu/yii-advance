<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\publish\SoftwarePublishSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-publish-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sp_id') ?>

    <?= $form->field($model, 'sp_sw_id') ?>

    <?= $form->field($model, 'sp_file_count') ?>

    <?= $form->field($model, 'sp_date') ?>

    <?= $form->field($model, 'sp_publisher') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
