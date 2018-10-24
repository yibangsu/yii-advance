<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\ReleaseNoteLanguage */

$this->title = Yii::t('app', 'Update Release Note Language: ' . $model->rnl_id, [
    'nameAttribute' => '' . $model->rnl_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Release Note Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rnl_id, 'url' => ['view', 'id' => $model->rnl_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="release-note-language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
