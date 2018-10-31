<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\forceUpgrade\ForceVersion */

$this->title = $model->fv_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Force Versions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="force-version-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->fv_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->fv_id], [
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
            'fv_id',
            'fv_sw_id',
            'fv_date',
            'fv_u_id',
        ],
    ]) ?>

</div>
