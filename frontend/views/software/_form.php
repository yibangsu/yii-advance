<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\software\Software */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sw_id')->textInput() ?>

    <?= $form->field($model, 'sw_ver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sw_creator')->textInput() ?>

    <?= $form->field($model, 'sw_expiration_date')->textInput() ?>

    <?= $form->field($model, 'sw_release_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sw_date')->textInput() ?>

    <?= $form->field($model, 'sw_puid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
