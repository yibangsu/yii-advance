<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\fotaSrc\FileBase;
use frontend\models\software\Software;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-extend-form">

    <?php 
    $projectName = Yii::$app->user->getUserCache('projectName');
    $categoryName = Yii::$app->user->getUserCache('categoryName');
    $puidName = Yii::$app->user->getUserCache('puidName');
    $pathName = Yii::$app->params['fotaPackagePath'] 
                         . $projectName . '/'
                         . $categoryName . '/'
                         . $puidName . '/';

    $filebases = FileBase::find()->where(['fb_path' => $pathName])->all();

    $puidId = Yii::$app->user->getUserCache('puidId');
    $versionList = Software::find()->where(['sw_puid' => $puidId])->all();
    ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'fe_fb_id')->dropDownList(ArrayHelper::map($filebases, 'fb_id', 'fb_name')) ?>

    <?= $form->field($model, 'fe_from_ver')->dropDownList(ArrayHelper::map($versionList, 'sw_id', 'sw_ver')) ?>

    <?= $form->field($model, 'fe_to_ver')->dropDownList(ArrayHelper::map($versionList, 'sw_id', 'sw_ver')) ?>

    <?= $form->field($model, 'fe_release_note')->textarea(['value' => $model->fe_release_note]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
