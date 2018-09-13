<?php

namespace frontend\models\upload;

use Yii;
use yii\base\Model;

use frontend\models\fotaSrc\FileBase;
use frontend\models\fotaSrc\FileExtend;

use frontend\models\software\Software;
use frontend\models\software\SoftwareSearch;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $fromVerId;
    public $toVerId;
    public $imageFile;

    public function rules()
    {
        return [
            //[['fromVerId', 'toVerId'], 'skipOnEmpty' => false],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip', 'maxSize' => '2147483648'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            // save upload package
            $puidName = Yii::$app->user->getUserCache('puidName');
            $saveDir = Yii::$app->params['fotaPackagePath'] . ($puidName? $puidName: 'temp') . '/';
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0775, true);
            }
            if (!$this->imageFile->saveAs($saveDir . $this->imageFile->baseName . '.' . $this->imageFile->extension)) {
                return false;
            }
            // save fota package info into FileBase db
            $fileBase = new FileBase();
            $fileBase->fb_name = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $fileBase->fb_path = $saveDir;
            $fileBase->fb_date = date("Y-m-d h:i:s",time());
            $fileBase->fb_size = filesize($fileBase->fb_path . $fileBase->fb_name);
            if (!$fileBase->save()) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}

