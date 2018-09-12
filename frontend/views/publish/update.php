<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\publish\SoftwarePublish */

$this->title = Yii::t('app', 'Update Software Publish: ' . $model->sp_id, [
    'nameAttribute' => '' . $model->sp_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Publishes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sp_id, 'url' => ['view', 'id' => $model->sp_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="software-publish-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
