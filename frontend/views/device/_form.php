<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\software\Software;
use frontend\models\fotaSrc\DeviceGroup;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    $puidId = Yii::$app->user->getUserCache('puidId');
    $versionList = Software::find()->where(['sw_puid' => $puidId])->all();
    $versionList[] = ['sw_ver' => Yii::t('app', 'No Choose')];
    $versionNum = count($versionList);

    $deviceGroupList = DeviceGroup::find()->all();
    ?>

    <?= $form->field($model, 'd_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_dg_id')->dropDownList(ArrayHelper::map($deviceGroupList, 'dg_id', 'dg_name')) ?>

    <?= $form->field($model, 'd_bind_ver')->dropDownList(ArrayHelper::map($versionList, 'sw_ver', 'sw_ver'), ['value' => 'No Choose']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
