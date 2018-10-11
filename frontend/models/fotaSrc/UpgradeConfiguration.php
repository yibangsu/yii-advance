<?php

namespace frontend\models\fotaSrc;

use Yii;
use frontend\models\puid\ProductInfo;

/**
 * This is the model class for table "Upgrade_Configuration".
 *
 * @property int $uc_id
 * @property int $uc_puid
 * @property int $uc_spop_template_id
 * @property string $uc_spop_value
 *
 * @property ProductInfo $ucPu
 * @property SPOPTemplate $ucSpopTemplate
 */
class UpgradeConfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Upgrade_Configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uc_puid', 'uc_spop_template_id', 'uc_spop_value'], 'required'],
            [['uc_puid', 'uc_spop_template_id'], 'integer'],
            [['uc_spop_value'], 'string', 'max' => 128],
            [['uc_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['uc_puid' => 'pi_id']],
            [['uc_spop_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => SPOPTemplate::className(), 'targetAttribute' => ['uc_spop_template_id' => 'template_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uc_id' => Yii::t('app', 'Uc ID'),
            'uc_puid' => Yii::t('app', 'Uc Puid'),
            'uc_spop_template_id' => Yii::t('app', 'Uc Spop Template ID'),
            'uc_spop_value' => Yii::t('app', 'Uc Spop Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUcPu()
    {
        return $this->hasOne(ProductInfo::className(), ['pi_id' => 'uc_puid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUcSpopTemplate()
    {
        return $this->hasOne(SPOPTemplate::className(), ['template_id' => 'uc_spop_template_id']);
    }
}
