<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\DeviceGroup */

$this->title = Yii::t('app', 'Update Device Group: ' . $model->dg_name, [
    'nameAttribute' => '' . $model->dg_name,
]);

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['/device/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Device Groups'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->dg_id, 'url' => ['view', 'id' => $model->dg_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="device-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
