<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\upload\UploadForm;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // 文件上传成功
                //return;
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
