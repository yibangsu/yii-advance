<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\fotaSrc\ReleaseNoteLanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Release Note Languages');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';
?>
<div class="release-note-language-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Release Note Language'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rnl_id',
            'rnl_tag',
            'rnl_note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
