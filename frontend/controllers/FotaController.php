<?php

namespace frontend\controllers;

use Yii;
use frontend\models\fotaSrc\FileBase;
use frontend\models\fotaSrc\FileExtend;
use frontend\models\fotaSrc\FotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use frontend\models\fotaSrc\FotaPackageUpload;
use frontend\models\operationRecord\OperationRecord;

/**
 * PackageController implements the CRUD actions for FileExtend model.
 */
class FotaController extends Controller
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
     * Lists all FileExtend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all FileBase models.
     * @return mixed
     */
    public function actionUpload()
    {
        $model = new FotaPackageUpload();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->upload() && $model->uploadReturn['id']) {
                $id = $model->uploadReturn['id'];
                $model = findModel($id);
                OperationRecord::record($model->tableName(), $id, $model? $model->fb_name: 'item not found!', OperationRecord::ACTION_ADD);
            }
        }

        return json_encode($model->uploadReturn);
    }

    /**
     * Displays a single FileExtend model.
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
     * Creates a new FileExtend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FotaPackageUpload();

        //if (Yii::$app->request->isPost) {
        //    $model->load(Yii::$app->request->post());
        //}
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->fe_id]);
        //}

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FileExtend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            OperationRecord::record($model->tableName(), $model->fe_id, $model->fb_name, OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->fe_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', "Update release note failed!\nPlease check if the release note keeps the same.\n"));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FileExtend model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->fe_id;
        $name = $model->fb_name;
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete fota package failed!'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the FileExtend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileExtend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $searchModel = new FotaSearch();
        $model = $searchModel->findOneById($id);

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $model;
    }
}
