<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\Device */

$this->title = Yii::t('app', 'Update Device: ' . $model->d_code, [
    'nameAttribute' => '' . $model->d_code,
]);

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->d_id, 'url' => ['view', 'id' => $model->d_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="device-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
