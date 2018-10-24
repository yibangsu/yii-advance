<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\fotaSrc\ReleaseNoteLanguage */

$this->title = Yii::t('app', 'Create Release Note Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Release Note Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="release-note-language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
