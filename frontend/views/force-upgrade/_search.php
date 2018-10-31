<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forceUpgrade\ForceVersionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="force-version-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fv_id') ?>

    <?= $form->field($model, 'fv_sw_id') ?>

    <?= $form->field($model, 'fv_date') ?>

    <?= $form->field($model, 'fv_u_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
