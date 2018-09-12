<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\puid\ProductInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pi_id')->textInput() ?>

    <?= $form->field($model, 'PUID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pi_cp_id')->textInput() ?>

    <?= $form->field($model, 'cp_used')->textInput() ?>

    <?= $form->field($model, 'pi_date')->textInput() ?>

    <?= $form->field($model, 'pi_u_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
