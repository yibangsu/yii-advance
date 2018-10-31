<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\software\Software;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forceUpgrade\ForceVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Force Upgrade');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';
?>
<div class="force-version-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="force-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $software = Software::findAll(['sw_puid' => $model->fv_puid]);
    ?>

    <?php
    if ($model->fv_sw_id) {
        $version = null;
        foreach ($software as $data) {
            if (strval($data->sw_id) === strval($model->fv_sw_id)) {
                $version = $data->sw_ver;
                break;
            }
        }
        echo Yii::t('app', 'Current force upgrade software is: ') . '<b>' . $version . '</b>.';
        echo '<br/>';
    } else {
        echo Yii::t('app', 'No software is forced upgrade! Please select and publish one.');
    }
    ?>

    <?= $form->field($model, 'fv_sw_id')->dropDownList(ArrayHelper::map($software, 'sw_id', 'sw_ver')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Delete'), Url::toRoute('/force-upgrade/delete-all'), ['data-method' => 'post', 'class' => 'btn btn-danger']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), Url::toRoute('/software/index'), ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
