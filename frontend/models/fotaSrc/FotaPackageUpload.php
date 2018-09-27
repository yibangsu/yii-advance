<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use frontend\models\fotaSrc\FileBase;
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip', 'maxSize' => '2147483648', 'maxLength' => 64],
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
        $this->blob = UploadedFile::getInstanceByName('blob');

        parent::load($data, $formName);

        return ($this->curBlobNum && $this->totalBlobNum && $this->file_name && $this->blob);
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
            $blob->saveAs($tempDir . $this->file_name . "." . $this->curBlobNum . ".temp");
        }
    }

    /**
     * @param fileBase FileBase
     * @param tempDir dir of the temp file
     */
    protected function saveTargetFile($fileBase, $deleteTemp = true) {
        $tempDir = Yii::$app->params['tempPackagePath'];
        if (!is_dir($tempDir)) return false;

        if (!is_dir($fileBase->fb_path)) {
            mkdir($fileBase->fb_path, 0755, true);
        }

        $tagetFile = fopen($fileBase->fb_path . $fileBase->fb_name, "wb");
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

    public function upload()
    {
        $this->isUploading = true;
       
        // save temp file
        $this->saveTempFile($this->blob);

        // if send over, merge target file and delete the temp
        if ($this->curBlobNum === $this->totalBlobNum) {
            $fileBase = new FileBase();
            $fileBase->load(null);
            $fileBase->fb_name = $this->file_name;

            // merge the target file
            $this->saveTargetFile($fileBase);

            // save in the file base table
            $fileBase->fb_date = date("Y-m-d h:i:s", filectime($fileBase->fb_path . $fileBase->fb_name));
            $fileBase->fb_size = filesize($fileBase->fb_path . $fileBase->fb_name);
            
            $datas = FileBase::find()->where(['fb_name' => $fileBase->fb_name])->all();
            if ($datas) {
                foreach ($datas as $data) {
                    $data->fb_path = $fileBase->fb_path;
                    $data->fb_date = $fileBase->fb_date;
                    $data->fb_size = $fileBase->fb_size;
                    $data->fb_status = $fileBase->fb_status;
                    $data->update();
                }
            } else {
                $fileBase->save();
            }

            $this->uploadReturn['finish'] = true;
        } else {
            $this->uploadReturn['finish'] = false;
        }
        $this->uploadReturn['curBlobNum'] = $this->curBlobNum + 1;

        return true;
    }

    public function setOver()
    {
        $this->uploadReturn['finish'] = true;
    }
}
