<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Upload Software');
// custom breadcrumbs with level
$uploadBreadcrumbsLevel = 0;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>

