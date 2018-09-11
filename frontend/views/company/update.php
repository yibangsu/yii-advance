<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\company\Company */

$this->title = Yii::t('app', 'Update Company: ' . $model->c_id, [
    'nameAttribute' => '' . $model->c_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->c_id, 'url' => ['view', 'id' => $model->c_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
