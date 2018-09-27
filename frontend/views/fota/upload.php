<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use yii\widgets\ActiveForm;
use common\assets\UploadFileAsset;

UploadFileAsset::register($this);

$this->title = Yii::t('app', 'Upload Fota Package');

// custom breadcrumbs with level
$breadcrumbsLevel = 5;
$skipMainTitle = true;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fota Package'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->fe_id, 'url' => ['view', 'id' => $model->fe_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="file-extend-upload">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Progress::widget([
      'percent' => ceil($model->blobNow / $model->totalBlobNum),
      'barOptions' => ['class' => 'progress-bar-success'],
      'options' => [
          'class' => 'active progress-striped',
          'style' => $model->isUploading? "": "display: none",
      ],
    ]); ?>

    <?php $form = ActiveForm::begin(['options' => ['style' => $model->isUploading? "display: none": ""]]); ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>

    
