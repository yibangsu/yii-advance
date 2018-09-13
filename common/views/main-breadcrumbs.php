<?php
use yii\helpers\Url;

### show breadcrumbs according to breadcrumbsLevel
$companyName = Yii::$app->user->getUserCompanyName();
$projectName = Yii::$app->user->getUserCache('projectName');
$categoryName = Yii::$app->user->getUserCache('categoryName');
$puidName = Yii::$app->user->getUserCache('puidName');
$fullBreadcrumbs[] = [
                         'label' => Yii::t('app', 'Companies'), 
                         'url' => Url::toRoute('company/index')
                     ];
$fullBreadcrumbs[] = [
                         'label' => $companyName? $companyName: Yii::t('app', 'Projects'), 
                         'url' => ['project/index']
                     ];
$fullBreadcrumbs[] = [
                         'label' => $projectName? $projectName: Yii::t('app', 'Categories'), 
                         'url' => ['category/index']
                     ];
$fullBreadcrumbs[] = [
                         'label' => $categoryName? $categoryName: Yii::t('app', 'PUID'), 
                         'url' => ['product-info/index']
                     ];
$fullBreadcrumbs[] = [
                         'label' => $puidName? $puidName: Yii::t('app', 'PUID'), 
                         'url' => ['software/index']
                     ];

if (isset($breadcrumbsLevel)) {
    for ($i = 0; $i < $breadcrumbsLevel; $i++) {
        $this->params['breadcrumbs'][] = $fullBreadcrumbs[$i];
    }
}

if (!isset($skipMainTitle) || !$skipMainTitle) {
    $this->params['breadcrumbs'][] = $this->title;
}

?>
