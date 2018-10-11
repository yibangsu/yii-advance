<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;

/**
 */
class UpgradeConfigSettings extends Model
{
    public $holders = [];

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        if (empty($data) || !is_array($data))
            return false;
        foreach ($data as $key => $value) {
            if ($key === "_csrf-frontend")
                continue;
            if (!$this->setConfig($key, $value)) {
                return false;
            }
        }
        return true;
    }

    /**
     *
     */
    protected function setConfig($key, $value)
    {
        $keyArray = explode(";", $key);
        $items = $this->holders;
        $item;
        do {
            $find = false;
            $index = array_shift($keyArray);
            foreach ($items as $item) {
                $name = preg_replace("/ /", "_", $item->name);
                if ($name === $index) {
                    $items = $item->children;
                    $find = true;
                    break;
                }
            }
            if ($find !== true) {
                return false;
            }
        } while (!empty($keyArray));

        $item->value = $value;
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $puid = Yii::$app->user->getUserCache('puidId');
        if ($puid) {
            $query = UpgradeConfiguration::find()->where(['uc_puid' => $puid]);
            $count = $query->count();
            if ($count > 0) {
                $configs = $query->all();
                foreach ($configs as $config) {
                    $template = SPOPTemplate::find()->where(['template_id' => $config->uc_spop_template_id])->one();
                    $this->holders[] = UpgradeConfigurationHolder::parse($config, $template);
                }
            } else {
                $templates = SPOPTemplate::find()->all();
                if ($templates) {
                    foreach ($templates as $temp) {
                        $config = new UpgradeConfiguration();
                        $config->uc_puid = $puid;
                        $config->uc_spop_template_id = $temp->template_id;
                        $this->holders[] = UpgradeConfigurationHolder::parse($config, $temp);
                    }
                }
            }
        }
    }

    /**
     * save settings
     */
    public function save()
    {
        foreach ($this->holders as $holder) {
            $array = $holder->getChildrenArray();
            $json = json_encode($array, JSON_NUMERIC_CHECK);
            $holder->config->uc_spop_value = $json;
            if (!$holder->config->save()) {
                return false;
            }
        }
        return true;
    }
}
