<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use frontend\models\role\Role;

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

        <?= Html::a(Yii::t('app', 'Fota Manager'), Url::toRoute('/fota/index'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Fota Configure'), Url::toRoute('/publish/settings'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Software Publish'), Url::toRoute('/publish/index'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Test Devices'), Url::toRoute('/device/index'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Force Upgrade'), Url::toRoute('/force-upgrade/index'), ['class' => 'btn btn-success']) ?>

        <?php
        if (Role::beAdmin()) {
            echo Html::a(Yii::t('app', 'Note Language'), Url::toRoute('/release-note-language/index'), ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'sw_id',
            'sw_ver',
            //'sw_creator',
            'sw_date',
            //'sw_puid',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $params = ['id' => $model->sw_id];
                    $params[0] = $this->context->id . '/' . $action; 
                    $params['name'] = Html::encode($model->sw_ver);

                    return Url::toRoute($params);
                },
            ],
        ],
    ]); ?>
</div>
