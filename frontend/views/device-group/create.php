<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\DeviceGroup */

$this->title = Yii::t('app', 'Create Device Group');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['/device/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Device Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
