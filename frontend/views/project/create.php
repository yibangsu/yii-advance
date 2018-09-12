<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\project\Project */
$this->title = Yii::t('app', 'Create Project');

// custom breadcrumbs with level
$breadcrumbsLevel = 2;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
