<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\puid\ProductInfo */

$this->title = Yii::t('app', 'Update Product Info: ' . $model->PUID, [
    'nameAttribute' => '' . $model->PUID,
]);

// custom breadcrumbs with level
$breadcrumbsLevel = 4;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="product-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
