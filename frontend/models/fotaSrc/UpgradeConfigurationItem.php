<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;

/**
 *
 */
class UpgradeConfigurationItem extends Model
{
    /**
     * mark of input type
     */
    const DROPLIST_TYPE = 0;

    const INPUT_TYPE = 1;

    public $type;

    /**
     * key of json
     */
    public $name;

    /**
     * value of json
     * see UpgradeConfiguration->uc_spop_value 
     */
    public $value;

    /**
     * only when SPOPData linked to SPOPTemplate is discrete
     * the value can be chosen
     */
    public $options = [];

    /**
     * only when SPOPData linked to SPOPTemplate is continuous
     * the min range
     */
    public $rangeMin;

    /**
     * only when SPOPData linked to SPOPTemplate is continuous
     * the max range
     */
    public $rangeMax;

    /**
     * the children items, if has
     */
    public $children = [];

    /**
     * the children items, if has
     */
    public $parent;

    /**
     * parse UpgradeConfiguration and SPOPTemplate, return an instance of UpgradeConfigurationItem
     * @param $configValue, string, UpgradeConfiguration->uc_spop_value
     * @param $templateContent, string, SPOPTemplate->template_content
     * @param $parent, the parent
     * @param $jsonKey, the json key
     * @return void
     */
    public static function generate($configValue, $templateContent, $parent)
    {
        $templateArray = json_decode(preg_replace('/<.*>/', '', $templateContent), true);
        $configArray = json_decode(preg_replace('/<.*>/', '', $configValue), true);
        foreach ($templateArray as $key => $value) {
            $item = new UpgradeConfigurationItem();
            // set name
            $item->name = $key;
            if (is_array($value) && !isset($value[0])) {
                $content = json_encode($value);
                UpgradeConfigurationItem::generate(isset($configArray[$key])? json_encode($configArray[$key]): null, $content, $item);
            } else {
                // set value if in config
                if (isset($configArray[$key])) {
                    $item->value = $configArray[$key];
                }
                // set type and range
                $item->setTypeAndRange($value[0]);
            }
            // set child to parent
            if ($parent instanceof UpgradeConfigurationItem) {
                $parent->children[] = $item;
                $item->parent = $parent;
            }
        }
    }

    /**
     *
     */
    protected function setTypeAndRange($id)
    {
        $data = SPOPData::find()->where(['spop_data_id' => $id])->one();
        if (isset($data['spop_data_value'])) {
            $range = $data['spop_data_value'];
            if (preg_match("/,/", $range)) {
                $this->type = self::DROPLIST_TYPE;
                $valueList = explode(",", $range);
                if (is_array($valueList) && count($valueList) > 0) {
                    foreach ($valueList as $value) {
                        $ttt = gettype($value);
                        $this->options[trim($value)] = trim($value);
                    }
                }
            } else if (preg_match("/:/", $range)) {
                $this->type = self::INPUT_TYPE;
                $valueRange = explode(":", $range);
                if (is_array($valueRange) && count($valueRange) === 2) {
                    $this->rangeMin = $valueRange[0];
                    $this->rangeMax = $valueRange[1];
                }
            } else {
                // ???
            }
        }
    }

    /**
     *
     */
    public function getFullName()
    {
        $parent = $this->parent;
        $name = $this->name;
        while ($parent != null) {
            $name = $parent->name . ";" . $name;
            $parent = $parent->parent;
        }
        return $name;
    }

    /**
     *
     */
    public function findChildByName($name)
    {
        foreach ($this->children as $child) {
            if ($child->name === $name) {
                return $child;
            }
        }
        return null;
    }

    /**
     *
     */
    public function toArray()
    {
        if (empty($this->children)) {
            return [$this->name => $this->value];
        } else {
            $childrenArray = [];
            foreach ($this->children as $child) {
                $childrenArray[] = $child->toArray();
            }
            return [$this->name => $childrenArray];
        }
    }

    /**
     *
     */
    public function getChildrenArray()
    {
        $childrenArray = [];
        foreach ($this->children as $child) {
            if ($child->value !== null) {
                $childrenArray[$child->name] = $child->value;
            } else {
                $childrenArray[$child->name] = $child->getChildrenArray();
            }
        }
        return $childrenArray;
    }

    /**
     *
     */
    public function toJson()
    {
        if (empty($this->children)) {
            return json_encode([$this->name => $this->value]);
        } else {
            $childrenJson = '';
            foreach ($this->children as $child) {
                if (empty($childrenJson)) {
                    $childrenJson = $child->toJson();
                } else {
                    $childrenJson = $childrenJson . ',' . $child->toJson();
                }
            }
            return json_encode([$this->name => $childrenJson]);
        }
    }
}
