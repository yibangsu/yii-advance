<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\Device */

$this->title = $model->d_code;

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->d_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->d_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'd_id',
            'd_code',
            'd_dg_id',
            'd_bind_ver',
            'd_date',
            'd_u_id',
        ],
    ]) ?>

</div>
