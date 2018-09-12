<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\publish\SoftwarePublish */

$this->title = $model->sp_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Publishes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-publish-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->sp_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->sp_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sp_id',
            'sp_sw_id',
            'sp_file_count',
            'sp_date',
            'sp_publisher',
        ],
    ]) ?>

</div>
