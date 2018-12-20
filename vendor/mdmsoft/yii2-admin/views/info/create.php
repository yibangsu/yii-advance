<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\company\Company;
use common\models\User;


/* @var $this yii\web\View */
/* @var $model backend\models\UserInfo\UserInfo */

$this->title = Yii::t('app', 'Create User Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-info-form">
    <?php
    $userList = User::find()->all();
    $companyList =  Company::find()->all();
    $enableList = ['Y' => 'Y', 'N' => 'N'];
    ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($userList, 'id', 'username')) ?>

    <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map($companyList, 'c_id', 'c_name')) ?>

    <?= $form->field($model, 'enable')->dropDownList($enableList) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
