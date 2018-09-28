<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\category\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = Yii::t('app', 'Categories');
$projectName = Yii::$app->user->getUserCache('projectName');
$this->title = $projectName? $projectName: Yii::t('app', 'Categories');

// custom breadcrumbs with level
$breadcrumbsLevel = 2;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'cp_id',
            'cp_name',
            //'cp_pj_id',

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
                    $params[0] = $this->context->id . '/' . $action; 
                    $params['name'] = Html::encode($model->cp_name);

                    return Url::toRoute($params);
                },
            ],
        ],
    ]); ?>
</div>
