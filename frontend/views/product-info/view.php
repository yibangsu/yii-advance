<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\puid\ProductInfo */

$this->title = $model->PUID;

// custom breadcrumbs with level
$breadcrumbsLevel = 4;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="product-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->pi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->pi_id], [
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
            //'pi_id',
            'PUID',
            //'pi_cp_id',
            'cp_used',
            'pi_date',
            //'pi_u_id',
        ],
    ]) ?>

</div>
