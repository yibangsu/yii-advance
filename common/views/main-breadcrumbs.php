<?php
use yii\helpers\Url;

### must set $breadcrumbsLevel first
$companyName = Yii::$app->user->getUserCompanyName();
$projectName = Yii::$app->user->getUserCache('projectName');
$categoryName = Yii::$app->user->getUserCache('categoryName');
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

if ($breadcrumbsLevel) {
    for ($i = 0; $i < $breadcrumbsLevel; $i++) {
        $this->params['breadcrumbs'][] = $fullBreadcrumbs[$i];
    }
}

$this->params['breadcrumbs'][] = $this->title;

?>
