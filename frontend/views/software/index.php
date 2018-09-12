<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\software\SoftwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$puidName = Yii::$app->user->getUserCache('puidName');
$this->title = $puidName? $puidName: Yii::t('app', 'Softwares');

// custom breadcrumbs with level
$breadcrumbsLevel = 4;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="software-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Software'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sw_id',
            'sw_ver',
            'sw_creator',
            'sw_expiration_date',
            'sw_release_note:ntext',
            //'sw_date',
            //'sw_puid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
