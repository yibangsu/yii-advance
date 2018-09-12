<?php

namespace frontend\models\upload;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $name = $this->imageFile->name;
            $tempName = $this->imageFile->tempName;
            Yii::warning("name='$name', tempName='$tempName'");
            $this->imageFile->saveAs(Yii::$app->getRuntimePath() . '/upload/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}

