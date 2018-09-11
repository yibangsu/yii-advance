<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\project\Project */

$this->title = Yii::t('app', 'Update Project: ' . $model->pj_id, [
    'nameAttribute' => '' . $model->pj_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pj_id, 'url' => ['view', 'id' => $model->pj_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
