<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OperationRecord\OperationRecord */

$this->title = Yii::t('app', 'Update Operation Record: ' . $model->or_id, [
    'nameAttribute' => '' . $model->or_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operation Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->or_id, 'url' => ['view', 'id' => $model->or_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="operation-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
