<?php

namespace frontend\models\fotaSrc;

use Yii;
use frontend\models\software\Software;
use frontend\models\puid\ProductInfo;

/**
 * This is the model class for table "File_Extend".
 *
 * @property int $fe_id
 * @property int $fe_fb_id
 * @property int $fe_from_ver
 * @property int $fe_to_ver
 * @property string $fe_checksum
 * @property string $fe_release_note
 * @property string $fe_expiration_date 
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
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver', 'fe_checksum', 'fe_expiration_date', 'fe_puid'], 'required'],
            [['fe_fb_id', 'fe_from_ver', 'fe_to_ver', 'fe_puid'], 'integer'],
            [['fe_checksum'], 'string', 'max' => 64],
            [['fe_expiration_date'], 'string', 'max' => 10], 
            [['fe_fb_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileBase::className(), 'targetAttribute' => ['fe_fb_id' => 'fb_id']],
            [['fe_from_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_from_ver' => 'sw_id']],
            [['fe_to_ver'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fe_to_ver' => 'sw_id']],
            [['fe_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['fe_puid' => 'pi_id']],
            [['fe_release_note'], 'safe'],
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
            'fe_from_ver' => Yii::t('app', 'Source Version'),
            'fe_to_ver' => Yii::t('app', 'Target Version'),
            'fe_checksum' => Yii::t('app', 'Checksum'),
            'fe_expiration_date' => Yii::t('app', 'Expiration Date'),
            'fe_puid' => Yii::t('app', 'Puid'),
            'fb_name' => Yii::t('app', 'File Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $record = FileExtend::find()->where(['fe_from_ver' => $this->fe_from_ver, 'fe_to_ver' => $this->fe_to_ver, 'fe_puid' => $this->fe_puid])
                      ->one();
        if ($record !== null) {
            $this->fe_id = $record->fe_id;
            $record->fe_fb_id = $this->fe_fb_id;
            $record->fe_checksum = $this->fe_checksum;
            $$record->fe_expiration_date = $this->fe_expiration_date;
            return $record->update();
        } else {
            return parent::save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        
        $this->fe_puid = Yii::$app->user->getUserCache('puidId');

        $filebase = FileBase::find()->where(['fb_id' => $this->fe_fb_id])->one();
        if ($filebase === null)
            return false;

        $this->fe_checksum = md5_file($filebase->fb_path . $filebase->fb_name);

        return $result;
    }
}
