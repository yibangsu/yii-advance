<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\category\Category */

$this->title = Yii::t('app', 'Create Category');

// custom breadcrumbs with level
$breadcrumbsLevel = 3;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
