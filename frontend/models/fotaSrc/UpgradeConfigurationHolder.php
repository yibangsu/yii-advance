<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;

/**
 *
 */
class UpgradeConfigurationHolder extends UpgradeConfigurationItem
{
    /**
     * 
     */
    public $config;

    /**
     * see SPOPTemplate->template_notice
     */
    public $hint;

    /**
     * parse UpgradeConfiguration and SPOPTemplate, return an instance of UpgradeConfigurationItem
     * @param $config, mixed, instance of UpgradeConfiguration
     * @param $template, mixed, instance of SPOPTemplate
     * @return mixed, instance of UpgradeConfigurationHolder
     */
    public static function parse($config, $template)
    {
        if ((!$config instanceof UpgradeConfiguration) || (!$template instanceof SPOPTemplate)) {
            return null;
        }
        $holder = new UpgradeConfigurationHolder();
        $holder->config = $config;
        $holder->name = $template->template_title;
        $holder->hint = $template->template_notice;
        UpgradeConfigurationItem::generate($config->uc_spop_value, $template->template_content, $holder);

        return $holder;
    }
}
