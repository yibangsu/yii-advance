<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileBase */

$this->title = Yii::t('app', 'Update File Base: ' . $model->fb_id, [
    'nameAttribute' => '' . $model->fb_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'File Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fb_id, 'url' => ['view', 'id' => $model->fb_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="file-base-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
