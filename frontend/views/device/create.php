<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\Device */

$this->title = Yii::t('app', 'Create Device');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
