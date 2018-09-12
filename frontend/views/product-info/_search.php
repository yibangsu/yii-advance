<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\puid\ProductInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pi_id') ?>

    <?= $form->field($model, 'PUID') ?>

    <?= $form->field($model, 'pi_cp_id') ?>

    <?= $form->field($model, 'cp_used') ?>

    <?= $form->field($model, 'pi_date') ?>

    <?php // echo $form->field($model, 'pi_u_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
