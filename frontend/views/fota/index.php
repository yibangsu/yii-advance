<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\fotaSrc\FotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fota Package');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="file-extend-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Link Fota Package'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fb_name',
            'sourceVersion',
            'targetVersion',
            'fe_checksum',
            'fe_release_note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
