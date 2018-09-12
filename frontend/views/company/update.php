<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\company\Company */

$this->title = Yii::t('app', 'Update Company: ' . $model->c_name, [
    'nameAttribute' => '' . $model->c_name,
]);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
// custom breadcrumbs with level
$breadcrumbsLevel = 1;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>
<div class="company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
