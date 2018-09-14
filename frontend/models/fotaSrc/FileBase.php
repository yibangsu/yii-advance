<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "File_Base".
 *
 * @property int $fb_id
 * @property string $fb_name
 * @property string $fb_path
 * @property int $fb_status
 * @property string $fb_date
 * @property int $fb_size
 *
 * @property FileExtend[] $fileExtends
 */
class FileBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'File_Base';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fb_name', 'fb_path', 'fb_status', 'fb_date', 'fb_size'], 'required'],
            [['fb_status', 'fb_size'], 'integer'],
            [['fb_date'], 'safe'],
            [['fb_name'], 'string', 'max' => 64],
            [['fb_path'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fb_id' => Yii::t('app', 'Fb ID'),
            'fb_name' => Yii::t('app', 'Fb Name'),
            'fb_path' => Yii::t('app', 'Fb Path'),
            'fb_status' => Yii::t('app', 'Fb Status'),
            'fb_date' => Yii::t('app', 'Fb Date'),
            'fb_size' => Yii::t('app', 'Fb Size'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileExtends()
    {
        return $this->hasMany(FileExtend::className(), ['fe_fb_id' => 'fb_id']);
    }
}
