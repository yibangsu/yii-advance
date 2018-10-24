<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\ReleaseNoteLanguage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="release-note-language-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rnl_tag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rnl_note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
