<?php

namespace app\controllers;

use Yii;
use app\models\ThietbiSearch;
use app\models\ActivitiesLog;
use app\models\Nhomtbi;
use app\models\NhomtbiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * NhomtbiController implements the CRUD actions for Nhomtbi model.
 */
class NhomtbiController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Nhomtbi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NhomtbiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nhomtbi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ThietbiSearch();
        $dataProvider = $searchModel->searchNhom(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Nhomtbi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-nhomtb')) {
            # code...
            $model = new Nhomtbi();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'device-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhóm thiết bị ". $model->MA_NHOM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;
        }
        
    }

    public function actionCreatePost($MA_NHOM, $TEN_NHOM)
    {
        $model = new Nhomtbi;
        $model->MA_NHOM = $MA_NHOM;
        $model->TEN_NHOM = $TEN_NHOM;
        $model->save();
        $log = new ActivitiesLog;
        $log->activity_type = 'device-add';
        $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhóm thiết bị ". $model->MA_NHOM;
        $log->user_id = Yii::$app->user->identity->id;
        $log->create_at = time();
        $log->save();
        return $this->redirect(['nhomtbi/index']);
    }

    /**
     * Updates an existing Nhomtbi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('create-nhomtb')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_NHOM]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
            
        }
    }

    /**
     * Deletes an existing Nhomtbi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-nhomtb')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
        
    }

    /**
     * Finds the Nhomtbi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nhomtbi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nhomtbi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
