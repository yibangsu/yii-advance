<?php

namespace frontend\controllers;

use Yii;
use frontend\models\software\Software;
use frontend\models\software\SoftwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\upload\UploadForm;
use yii\web\UploadedFile;
use frontend\models\operationRecord\OperationRecord;

/**
 * SoftwareController implements the CRUD actions for Software model.
 */
class SoftwareController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays the upload model.
     * @return mixed
     */
/*
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                // 文件上传
                $model->upload();
            } else {

            }
        }

        $searchModel = new SoftwareSearch();
        $dataProvider = $searchModel->search(null);
        if ($dataProvider->query->count() < 2) {
            $this->goBack();
        }
        $versionList = $dataProvider->query->all();

        return $this->render('upload', [
            'model' => $model,
            'versionList' => $versionList,
        ]);
    }
*/
    /**
     * Lists all Software models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SoftwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Software model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Software model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Software();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->sw_id, $model->sw_ver, OperationRecord::ACTION_ADD);
            return $this->redirect(['view', 'id' => $model->sw_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Create software failed!'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Software model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->sw_id, $model->sw_ver, OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->sw_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Update software failed!'));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Software model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->sw_id;
        $name = $model->sw_ver;
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete software failed!'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Software model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Software the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Software::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
