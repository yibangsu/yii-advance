<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forceUpgrade\ForceVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="force-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fv_sw_id')->textInput() ?>

    <?= $form->field($model, 'fv_date')->textInput() ?>

    <?= $form->field($model, 'fv_u_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
