<?php

namespace frontend\controllers;

use Yii;
use frontend\models\fotaSrc\DeviceGroup;
use frontend\models\fotaSrc\DeviceGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\operationRecord\OperationRecord;

/**
 * DeviceGroupController implements the CRUD actions for DeviceGroup model.
 */
class DeviceGroupController extends Controller
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
     * Lists all DeviceGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeviceGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeviceGroup model.
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
     * Creates a new DeviceGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeviceGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->dg_id, $model->dg_name, OperationRecord::ACTION_ADD);
            return $this->redirect(['view', 'id' => $model->dg_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Create device group failed!'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DeviceGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->dg_id, $model->dg_name, OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->dg_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Update device group failed!'));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DeviceGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->dg_id;
        $name = $model->dg_name;
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete device group failed!'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the DeviceGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeviceGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeviceGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
