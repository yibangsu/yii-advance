<?php
use yii\helpers\Url;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Fota Manager', 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Project Manager'), 'icon' => 'dashboard', 'url' => Url::toRoute('company/index')],
                    ['label' => Yii::t('app', 'Software Manager'), 'icon' => 'file-code-o', 'url' => Url::toRoute('upload/index')],
                ],
            ]
        ) ?>

    </section>

</aside>
