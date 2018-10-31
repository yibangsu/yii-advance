<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OperationRecord\OperationRecord */

$this->title = Yii::t('app', 'Create Operation Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operation Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
