<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\company\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
//$this->params['breadcrumbs'][] = $this->title;
// custom breadcrumbs with level
$breadcrumbsLevel = 0;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php //echo Html::a(Yii::t('app', 'aws'), ['aws'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'c_id',
            'c_name',
            'c_site',
            'c_desc',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{next} {view} {update} {delete}',
                'visibleButtons' => [
                    'next' => true,
                    //'view' => Yii::$app->user->canEdit("add company"),
                    //'update' => Yii::$app->user->canEdit("add company"),
                    //'delete' => Yii::$app->user->canEdit("add company"),
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    $params = is_array($key) ? $key : ['id' => (string) $key];
                    $params['name'] = Html::encode($model->c_name);
                    $params[0] = $this->context->id . '/' . $action; 

                    return Url::toRoute($params);
                },
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
