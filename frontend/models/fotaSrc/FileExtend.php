<?php

namespace frontend\models\fotaSrc;

use Yii;
use frontend\models\software\Software;

/**
 * This is the model class for table "File_Extend".
 *
 * @property int $fe_id
 * @property int $fe_fb_id
 * @property int $fe_from_ver
 * @property int $fe_to_ver
 * @property string $fe_checksum
 * @property int $fe_puid
 *
 * @property FileBase $feFb
 * @property Software $feFromVer
 * @property Software $feToVer
 * @property ProductInfo $fePu
 */
class FileExtend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'File_Extend';
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \common\db\ActiveRecord::attributes()
     */
    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'sourceVersion';
        $attributes[] = 'targetVersion';
        $attributes[] = 'fb_name';
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver', 'fe_checksum', 'fe_puid'], 'required'],
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver', 'fe_puid'], 'integer'],
            [['fe_checksum'], 'string', 'max' => 64],
            [['fe_fb_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileBase::className(), 'targetAttribute' => ['fe_fb_id' => 'fb_id']],
            [['fe_from_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_from_ver' => 'sw_id']],
            [['fe_to_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_to_ver' => 'sw_id']],
            [['fe_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['fe_puid' => 'pi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fe_id' => Yii::t('app', 'File Extend ID'),
            'fe_fb_id' => Yii::t('app', 'File Base ID'),
            'fe_from_ver' => Yii::t('app', 'Source Version ID'),
            'fe_to_ver' => Yii::t('app', 'Target Version ID'),
            'fe_checksum' => Yii::t('app', 'Checksum'),
            'fe_puid' => Yii::t('app', 'Puid'),
            'sourceVersion' => Yii::t('app', 'Source Version'),
            'targetVersion' => Yii::t('app', 'Target Version'),
            'fb_name' => Yii::t('app', 'Fota Package'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasFileBase()
    {
        return $this->hasOne(FileBase::className(), ['fb_id' => 'fe_fb_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasSourceVersion()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fe_from_ver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasTargetVersion()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fe_to_ver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasPuid()
    {
        return $this->hasOne(ProductInfo::className(), ['pi_id' => 'fe_puid']);
    }
}
