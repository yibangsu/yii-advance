<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\puid\ProductInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$categoryName = Yii::$app->user->getUserCache('categoryName');
$this->title = $categoryName? $categoryName: Yii::t('app', 'Product Infos');

// custom breadcrumbs with level
$breadcrumbsLevel = 3;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="product-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pi_id',
            'PUID',
            'pi_cp_id',
            'cp_used',
            'pi_date',
            //'pi_u_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
