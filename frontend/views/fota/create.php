<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\FileExtend */

$this->title = Yii::t('app', 'Create File Extend');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-extend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
