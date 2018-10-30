<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\fotaSrc\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Devices');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';
?>
<div class="device-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Device'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Device Groups'), ['/device-group/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'d_id',
            'd_code',
            //'d_dg_id',
            'deviceGroupName',
            'd_bind_ver',
            'd_date',
            'creator',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
