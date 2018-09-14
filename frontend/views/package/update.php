<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */

$this->title = Yii::t('app', 'Update File Extend: ' . $model->fb_name, [
    'nameAttribute' => '' . $model->fb_name,
]);

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->fe_id, 'url' => ['view', 'id' => $model->fe_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="file-extend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
