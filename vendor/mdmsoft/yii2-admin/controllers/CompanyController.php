<?php

namespace mdm\admin\controllers;

use Yii;
use frontend\models\company\Company;
use frontend\models\company\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\operationRecord\OperationRecord;

use Aws\S3\S3Client;
use Aws\Sdk;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Go to next web page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionNext($id, $name)
    {
        return $this->redirect(['project/index']);
    }

    /**
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->c_id, $model->c_name, OperationRecord::ACTION_ADD);
            return $this->redirect(['view', 'id' => $model->c_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Create company failed!'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            OperationRecord::record($model->tableName(), $model->c_id, $model->c_name, OperationRecord::ACTION_UPDATE);
            return $this->redirect(['view', 'id' => $model->c_id]);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Update company failed!'));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $table = $model->tableName();
        $id = $model->c_id;
        $name = $model->c_name;
        $result = $model->delete();
        if ($result) {
            OperationRecord::record($table, $id, $name, OperationRecord::ACTION_DELETE);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Delete company failed!'));
        }

        return $this->redirect(['index']);
    }

/*
    public function actionAws()
    {
        // Use the us-east-2 region and latest version of each client.
        $sharedConfig = [
            'profile' => 'default',
            'region'  => 'us-west-2',
            'version' => 'latest'
        ];

        // Create an SDK class used to share configuration across clients.
        $sdk = new \Aws\Sdk($sharedConfig);

        // Use an Aws\Sdk class to create the S3Client object.
        $s3Client = $sdk->createS3();

        // Send a PutObject request and get the result object.
/*
/*
        $result = $s3Client->putObject([
            'Bucket' => 'create-han-test',
            'Key'    => 'S3-test.txt',
            'Body'   => 'this is php sdk test!',
        ]);

        // Download the contents of the object.
        $result = $s3Client->getObject([
            'Bucket' => 'create-han-test',
            'Key'    => 'S3-test.txt',
        ]);
        

        // Print the body of the result by indexing into the result object.
        Yii::$app->session->setFlash('error', $result['Body']->__toString());
*/
/*
        // use for large file upload
        //use Aws\S3\MultipartUploader;
        //use Aws\Exception\MultipartUploadException;

        $uploader = new MultipartUploader($s3Client, '/data/suyibang/Downloads/QS5509QL_v1A71_TO_v1A72_rezip.zip', [
            'bucket' => 'create-han-test',
            'key'    => 'test.zip',
        ]);

        try {
            $result = $uploader->upload();
            Yii::$app->session->setFlash('success',  "Upload complete: {$result['ObjectURL']}");
        } catch (MultipartUploadException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
*/
    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
