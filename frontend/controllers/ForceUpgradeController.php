<?php

namespace frontend\controllers;

use Yii;
use frontend\models\forceUpgrade\ForceVersion;
use frontend\models\forceUpgrade\ForceVersionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\operationRecord\OperationRecord;
use frontend\models\software\Software;

/**
 * ForceUpgradeController implements the CRUD actions for ForceVersion model.
 */
class ForceUpgradeController extends Controller
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
     * Lists all ForceVersion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModelByPuid(Yii::$app->user->getUserCache('puidId'));

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $id = $model->fv_id;
                $software = Software::findOne(['sw_id' => $model->fv_sw_id]);
                OperationRecord::record($model->tableName(), $id, $software? $software->sw_ver: 'item not found!', OperationRecord::ACTION_UPDATE);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Set force upgrade version failed'));
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single ForceVersion model.
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
     * Creates a new ForceVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*
    public function actionCreate()
    {
        $model = new ForceVersion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->fv_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Updates an existing ForceVersion model.
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
            return $this->redirect(['view', 'id' => $model->fv_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Deletes an existing ForceVersion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
/*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
*/

    /**
     * Remove published software.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAll()
    {
        $searchModel = new ForceVersionSearch();
        $searchModel->removeAll();
        OperationRecord::record($searchModel->tableName(), 0, 'all', OperationRecord::ACTION_DELETE_ALL);

        return $this->redirect(['index']);
    }

    /**
     * Finds the ForceVersion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ForceVersion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ForceVersion::findOne($id)) !== null) {
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
        if (($model = ForceVersion::findOne(['fv_puid' => $puid])) !== null) {
            return $model;
        }

        return new ForceVersion();
    }
}
