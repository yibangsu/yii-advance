<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Upload Software');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>

<div class="upload-software">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'fromVerId')->dropDownList(ArrayHelper::map($versionList, 'sw_id', 'sw_ver')); ?>

        <?= $form->field($model, 'toVerId')->textInput() ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end() ?>

</div>
