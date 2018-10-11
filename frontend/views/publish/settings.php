<?php

use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use frontend\models\fotaSrc\UpgradeConfigurationItem;
use frontend\models\fotaSrc\UpgradeConfigurationHolder;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\publish\SoftwarePublishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Upgrade Configure Settings');
// custom breadcrumbs with level
$breadcrumbsLevel = 5;
require __DIR__ . '/../../../common/views/main-breadcrumbs.php';
?>
<div class="software-publish-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
</div>

<div class="file-extend-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
    function showItem($item) {
        if ($item->type === UpgradeConfigurationItem::DROPLIST_TYPE) {
            echo "<label class=\"control-label\">&nbsp&nbsp" . $item->name . "&nbsp&nbsp</label>";
            echo Html::dropDownList($item->getFullName(), $item->value, $item->options);
        } else if ($item->type === UpgradeConfigurationItem::INPUT_TYPE) {
            echo "<label class=\"control-label\">&nbsp&nbsp" . $item->name . "&nbsp&nbsp</label>";
            echo Html::textInput($item->getFullName(), $item->value);
        } else if (!empty($item->children)) {
            echo "<br/>";
            foreach ($item->children as $child) {
                showItem($child);
            }
        }
    }
    ?>
    <?php 
        $holders = $model->holders;
        if ($holders) {
            foreach ($holders as $holder) {
                echo "<div class=\"form-group\">";
                echo "<label class=\"control-label\">" . $holder->name . "</label>";
                showItem($holder);
                echo "</div>";
            }
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['software/index'], ['class' => 'btn btn-danger', "style" => "margin-left:100px"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
JS;
$this->registerJs($js);
?>
