<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\forceUpgrade\ForceVersion */

$this->title = Yii::t('app', 'Create Force Version');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Force Versions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="force-version-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
