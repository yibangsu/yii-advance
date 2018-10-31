<?php

namespace frontend\controllers;

use Yii;
use frontend\models\fotaSrc\ReleaseNoteLanguage;
use frontend\models\fotaSrc\ReleaseNoteLanguageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\operationRecord\OperationRecord;

/**
 * ReleaseNoteLanguageController implements the CRUD actions for ReleaseNoteLanguage model.
 */
class ReleaseNoteLanguageController extends Controller
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
     * Lists all ReleaseNoteLanguage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReleaseNoteLanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReleaseNoteLanguage model.
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
     * Creates a new ReleaseNoteLanguage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReleaseNoteLanguage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->rnl_id, $model->rnl_note, OperationRecord::ACTION_ADD);
            return $this->redirect(['view', 'id' => $model->rnl_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Create release note language failed!'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReleaseNoteLanguage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->rnl_id, $model->rnl_note, OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->rnl_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Update release note language failed!'));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReleaseNoteLanguage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->rnl_id;
        $name = $model->rnl_note;
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete release note language failed!'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReleaseNoteLanguage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReleaseNoteLanguage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReleaseNoteLanguage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
