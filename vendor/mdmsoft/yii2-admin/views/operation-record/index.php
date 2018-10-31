<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OperationRecord\OperationRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Operation Records');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a(Yii::t('app', 'Create Operation Record'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'or_id',
            //'or_u_id',
            'username',
            'or_table_name',
            'or_table_item_id',
            'or_table_item_name',
            'or_table_action',
            'or_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '',
            ],
        ],
    ]); ?>
</div>
