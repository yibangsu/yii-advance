<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "SPOP_Template".
 *
 * @property int $template_id
 * @property string $template_title
 * @property string $template_content
 * @property string $template_notice
 *
 * @property UpgradeConfiguration[] $upgradeConfigurations
 */
class SPOPTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SPOP_Template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_title', 'template_content'], 'required'],
            [['template_title'], 'string', 'max' => 64],
            [['template_content', 'template_notice'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'template_id' => Yii::t('app', 'Template ID'),
            'template_title' => Yii::t('app', 'Template Title'),
            'template_content' => Yii::t('app', 'Template Content'),
            'template_notice' => Yii::t('app', 'Template Notice'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradeConfigurations()
    {
        return $this->hasMany(UpgradeConfiguration::className(), ['uc_spop_template_id' => 'template_id']);
    }
}
