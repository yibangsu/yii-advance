<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\project\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = Yii::t('app', 'Projects');
$companyName = Yii::$app->user->getUserCompanyName();
$this->title = $companyName? $companyName: Yii::t('app', 'Projects');

// custom breadcrumbs with level
$breadcrumbsLevel = 1;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pj_id',
            'pj_name',
            'pj_desc',
            //'pj_c_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{next} {view} {update} {delete}',
                'visibleButtons' => [
                    'next' => true,
                    //'view' => Yii::$app->user->canEdit(ProjectSearch::tableName()),
                    //'update' => Yii::$app->user->canEdit(ProjectSearch::tableName()),
                    //'delete' => Yii::$app->user->canEdit(ProjectSearch::tableName()),
                 ],
                 'urlCreator' => function ($action, $model, $key, $index, $this) {
                    $params = is_array($key) ? $key : ['id' => (string) $key];
                    $params[0] = $this->context->id . '/' . $action; 
                    $params['name'] = Html::encode($model->pj_name);

                    return Url::toRoute($params);
                },
            ],
        ],
    ]); ?>
</div>
