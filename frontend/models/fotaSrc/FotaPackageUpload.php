<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 */
class FotaPackageUpload extends Model
{
    public $blob;
    public $file;
    public $file_name;
    public $curBlobNum;
    public $totalBlobNum = 1;
    public $isUploading = false;
    public $uploadReturn = [];
    public $fromVersion;
    public $toVersion;
    public $releaseNote;
    public $language;
    public $langNote;
    public $expireDate;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'compare', 'toVersion'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip', 'maxSize' => '2147483648', 'maxLength' => 64],
            [['fromVersion', 'toVersion'], 'integer', 'skipOnEmpty' => false],
            ['toVersion', 'compare', 'skipOnEmpty' => false, 'compareAttribute' => 'fromVersion', 'operator' => '!=', 'message' => Yii::t('app', 'Target version should be different with source version!')],
            ['expireDate', 'date', 'skipOnEmpty' => false, 'format' => "yyyy-MM-dd"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $this->curBlobNum = isset($data['curBlobNum'])? $data['curBlobNum']: null;
        $this->totalBlobNum = isset($data['totalBlobNum'])? $data['totalBlobNum']: null;
        $this->file_name = isset($data['fb_name'])? $data['fb_name']: null;
        $this->fromVersion = isset($data['fromVersion'])? $data['fromVersion']: null;
        $this->toVersion = isset($data['toVersion'])? $data['toVersion']: null;
        $this->releaseNote = isset($data['releaseNote'])? $data['releaseNote']: null;
        $this->expireDate = isset($data['expireDate'])? $data['expireDate']: null;
        if (empty($this->expireDate)) {
            $this->expireDate = 'never';
        }
        $this->blob = UploadedFile::getInstanceByName('blob');

        parent::load($data, $formName);

        return ($this->curBlobNum && $this->totalBlobNum && $this->file_name 
                    && $this->blob && $this->fromVersion && $this->toVersion && $this->expireDate);
    }

    /**
     * @param blob UploadedFile
     * @param tempDir dir of the temp file
     */
    protected function saveTempFile($blob) {
        $tempDir = Yii::$app->params['tempPackagePath'];
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        if ($blob) {
            return $blob->saveAs($tempDir . $this->file_name . "." . $this->curBlobNum . ".temp");
        }

        return false;
    }

    /**
     * @param fileBase FileBase
     * @param tempDir dir of the temp file
     */
    protected function saveTargetFile($deleteTemp = true) {
        $tempDir = Yii::$app->params['tempPackagePath'];
        if (!is_dir($tempDir)) return false;

        // get the target dir...
        $fileBase = new FileBase();
        $fileBase->load(null);

        if (!is_dir($fileBase->fb_path)) {
            mkdir($fileBase->fb_path, 0755, true);
        }

        $tagetFile = fopen($fileBase->fb_path . $this->file_name, "wb");
        if (!$tagetFile) return false;

        for ($i=1; $i<=$this->totalBlobNum; $i++) {
            // read temp file
            $tempFileName = $tempDir . $this->file_name . "." . $i . ".temp";
            $tempFile = fopen($tempFileName, "rb");
            if (!$tempFile) return false;
            $tempContent = fread($tempFile, filesize($tempFileName));
            fclose($tempFile);
            if ($deleteTemp) {
                unlink($tempFileName);
            }
            // write the target file
            fwrite($tagetFile, $tempContent);
        }

        fclose($tagetFile);

        return true;
    }

    protected function saveDbInfo()
    {
        $fileBase = new FileBase();
        $fileBase->load(null);
        $fileBase->fb_name = $this->file_name; // need file name to save file extend
        $datas = FileBase::find()->where(['fb_name' => $fileBase->fb_name, 'fb_path' => $fileBase->fb_path])->all();
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $data->fb_date = date("Y-m-d h:i:s", filectime($data->fb_path . $data->fb_name));
                $data->fb_size = filesize($data->fb_path . $data->fb_name);
                $data->fb_status = $fileBase->fb_status;
                $data->update();
                $fileBase->fb_id = $data->fb_id; // need a fb id for fe
            }
        } else {
            $fileBase->fb_date = date("Y-m-d h:i:s", filectime($fileBase->fb_path . $fileBase->fb_name));
            $fileBase->fb_size = filesize($fileBase->fb_path . $fileBase->fb_name);
            $fileBase->save();
        }

        // save file extends
        $fileExtend = new FileExtend();
        $fileExtend->load(null);
        $datas = FileExtend::findAll(['fe_from_ver' => $this->fromVersion, 'fe_to_ver' => $this->toVersion, 'fe_puid' => $fileExtend->fe_puid]);
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $data->fe_fb_id = $fileBase->fb_id;
                $data->fe_checksum = md5_file($fileBase->fb_path . $fileBase->fb_name);
                $data->fe_release_note = $this->releaseNote;
                $data->fe_expiration_date = $this->expireDate;
                $data->update();
                $fileExtend->fe_id = $data->fe_id;
            }
        } else {
            $fileExtend->fe_fb_id = $fileBase->fb_id;
            $fileExtend->fe_from_ver = $this->fromVersion;
            $fileExtend->fe_to_ver = $this->toVersion;
            $fileExtend->fe_checksum = md5_file($fileBase->fb_path . $fileBase->fb_name);
            $fileExtend->fe_release_note = $this->releaseNote;
            $fileExtend->fe_expiration_date = $this->expireDate;
            $fileExtend->save();
        }

        return $fileExtend->fe_id;
    }

    public function upload()
    {
        $this->isUploading = true;
       
        // save temp file
        if (!$this->saveTempFile($this->blob)) {
            $this->uploadReturn['error'] = 'saveTempFileError';
            $this->isUploading = false;
            return false;
        }

        // if send over, merge target file and delete the temp
        if ($this->curBlobNum === $this->totalBlobNum) {
            $this->uploadReturn['finish'] = true;

            // merge the target file
            if ($this->saveTargetFile()) {
                $id = $this->saveDbInfo();
                $this->uploadReturn['id'] = $id;
                return true;
            } else {
                $this->uploadReturn['error'] = 'saveTargetFileError';
                return false;
            }
        } else {
            $this->uploadReturn['finish'] = false;
            $this->uploadReturn['curBlobNum'] = $this->curBlobNum + 1;

            return false;
        }
        

        return false;
    }

    public function setOver()
    {
        $this->uploadReturn['finish'] = true;
    }
}
