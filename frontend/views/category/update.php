<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\category\Category */

$this->title = Yii::t('app', 'Update Category: ' . $model->cp_id, [
    'nameAttribute' => '' . $model->cp_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cp_id, 'url' => ['view', 'id' => $model->cp_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
