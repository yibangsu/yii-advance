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
     * {@inheritdoc}
     */
/*
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['todoSave'] = array_keys($this->attributes);
        return $scenarios;
    }
*/

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
        $attributes[] = 'imageFile';
        $attributes[] = 'versionList';
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
            // rules for file
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip', 'maxSize' => '2147483648', 'except' => 'todoSave'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip', 'maxSize' => '2147483648', 'maxLength' => 64],
            // how to make sure fe_from_ver is defferent to fe_to_ver?
            // todo
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
            'fe_puid' => Yii::t('app', 'Puid'),
            'sourceVersion' => Yii::t('app', 'Source Version'),
            'targetVersion' => Yii::t('app', 'Target Version'),
            'fb_name' => Yii::t('app', 'Fota Package'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        
        $this->fe_puid = Yii::$app->user->getUserCache('puidId');

        $result = $result && $this->fe_puid;

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function allSave($isNew = false, $runValidation = true, $attributeNames = null) 
    {
        if (!$this->imageFile) return false;

        $result = true;
        // save upload package
        $puidName = Yii::$app->user->getUserCache('puidName');
        $saveDir = Yii::$app->params['fotaPackagePath'] . ($puidName? $puidName: 'temp') . '/';
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0775, true);
        }

        if (!$this->imageFile->saveAs($saveDir . $this->imageFile->name, false)) {
            $temp = $this->imageFile->tempName;
            $name = $this->imageFile->name;
            Yii::warning("Can't save file $temp as $saveDir$name");
            return false;
        }
        // save fota package info into FileBase db
        $fileBase = new FileBase();
        if ($isNew) {
            $fileBase->fb_name = $this->imageFile->name;
            $fileBase->fb_path = $saveDir;
            $fileBase->fb_status = 1;
            $fileBase->fb_date = date("Y-m-d h:i:s",time());
            $fileBase->fb_size = filesize($fileBase->fb_path . $fileBase->fb_name);
        } else {
            $fileBase = FileBase::find()->where(['fb_id' => $this->fe_fb_id])->one();
        }
        if (!$fileBase->save()) {
            $result = false;
        }

        // save fota package info into FileExtend db
        $this->fe_checksum = md5_file($fileBase->fb_path . $fileBase->fb_name);
        $this->fe_fb_id = $fileBase->fb_id;
        if (!$this->save(true, ['fe_from_ver', 'fe_to_ver', 'fe_puid', 'fe_checksum', 'fe_fb_id'])) {
            $result = false;
        }
        // remove temp file
        unlink($this->imageFile->tempName);

        return $result;
    }

    /**
     * get software version list
     *
     * @return mixed array of frontend\models\software\Software
     */
    public function getSoftwareList()
    {
        $puidId = Yii::$app->user->getUserCache('puidId');
        $this->versionList = Software::find()->where(['sw_puid' => $puidId])->all();
        return $this->versionList;
    }
}
