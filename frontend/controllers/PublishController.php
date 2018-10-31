<?php

namespace frontend\controllers;

use Yii;
use frontend\models\publish\SoftwarePublish;
use frontend\models\publish\SoftwarePublishSearch;
use frontend\models\fotaSrc\UpgradeConfigSettings;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\operationRecord\OperationRecord;

use frontend\models\software\Software;

/**
 * PublishController implements the CRUD actions for SoftwarePublish model.
 */
class PublishController extends Controller
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
                    'delete-all' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SoftwarePublish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModelByPuid(Yii::$app->user->getUserCache('puidId'));

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $id = $model->sp_id;
                $software = Software::findOne(['sw_id' => $model->sp_sw_id]);
                OperationRecord::record($model->tableName(), $id, $software? $software->sw_ver: 'item not found!', OperationRecord::ACTION_UPDATE);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Set publish version failed'));
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single SoftwarePublish model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
/*
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
*/
    /**
     * Creates a new SoftwarePublish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*
    public function actionCreate()
    {
        $model = new SoftwarePublish();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $id = $model->sp_id;
            $software = Software::findOne(['sw_id' => $model->sp_sw_id]);
            OperationRecord::record($model->tableName(), $id, $software? $software->sw_ver: 'item not found!', OperationRecord::ACTION_ADD);
            return $this->redirect(['view', 'id' => $model->sp_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Publish software failed!'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Updates an existing SoftwarePublish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
/*
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $id = $model->sp_id;
            $software = Software::findOne(['sw_id' => $model->sp_sw_id]);
            OperationRecord::record($model->tableName(), $id, $software? $software->sw_ver: 'item not found!', OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->sp_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Update publish failed!'));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Deletes an existing SoftwarePublish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
/*
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->sp_id;
        $software = Software::findOne(['sw_id' => $model->sp_sw_id]);
        $name = $software? $software->sw_ver: 'item not found!';
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete publish failed!'));
        }
        return $this->redirect(['index']);
    }
*/
    /**
     * Set spop.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSettings()
    {
        $model = new UpgradeConfigSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record('Upgrade_Configuration', intval(Yii::$app->user->getUserCache('puidId')), 'Configuration', OperationRecord::ACTION_UPDATE);
            $this->redirect(['/software/index']);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Set configurations failed!'));
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }

    /**
     * Remove published software.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAll()
    {
        $searchModel = new SoftwarePublishSearch();
        $searchModel->removeAll();
        OperationRecord::record($searchModel->tableName(), 0, 'all', OperationRecord::ACTION_DELETE_ALL);

        return $this->redirect(['index']);
    }

    /**
     * Finds the SoftwarePublish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SoftwarePublish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SoftwarePublish::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the SoftwarePublish model based on its puid.
     * @param integer $puid
     * @return SoftwarePublish the loaded model
     */
    protected function findModelByPuid($puid)
    {
        if (($model = SoftwarePublish::findOne(['sp_puid' => $puid])) !== null) {
            return $model;
        }

        return new SoftwarePublish();
    }

}
