<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\software\Software */

$this->title = Yii::t('app', 'Update Software: ' . $model->sw_ver, [
    'nameAttribute' => '' . $model->sw_ver,
]);
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';
?>
<div class="software-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
