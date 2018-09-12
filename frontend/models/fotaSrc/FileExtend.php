<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "File_Extend".
 *
 * @property int $fe_id
 * @property int $fe_fb_id
 * @property int $fe_from_ver
 * @property int $fe_to_ver
 * @property string $fe_checksum
 *
 * @property FileBase $feFb
 * @property Software $feFromVer
 * @property Software $feToVer
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver'], 'required'],
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver'], 'integer'],
            [['fe_checksum'], 'string', 'max' => 32],
            [['fe_fb_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileBase::className(), 'targetAttribute' => ['fe_fb_id' => 'fb_id']],
            [['fe_from_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_from_ver' => 'sw_id']],
            [['fe_to_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_to_ver' => 'sw_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fe_id' => Yii::t('app', 'Fe ID'),
            'fe_fb_id' => Yii::t('app', 'Fe Fb ID'),
            'fe_from_ver' => Yii::t('app', 'Fe From Ver'),
            'fe_to_ver' => Yii::t('app', 'Fe To Ver'),
            'fe_checksum' => Yii::t('app', 'Fe Checksum'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeFb()
    {
        return $this->hasOne(FileBase::className(), ['fb_id' => 'fe_fb_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeFromVer()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fe_from_ver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeToVer()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fe_to_ver']);
    }
}
