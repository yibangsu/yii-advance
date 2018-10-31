<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\forceUpgrade\ForceVersion */

$this->title = Yii::t('app', 'Update Force Version: ' . $model->fv_id, [
    'nameAttribute' => '' . $model->fv_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Force Versions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fv_id, 'url' => ['view', 'id' => $model->fv_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="force-version-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
