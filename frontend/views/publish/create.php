<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\publish\SoftwarePublish */

$this->title = Yii::t('app', 'Create Software Publish');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Publishes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-publish-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
