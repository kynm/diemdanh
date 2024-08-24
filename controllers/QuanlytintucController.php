<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Hocsinh;
use app\models\Tintuc;
use app\models\TintucSearch;
use app\models\ChitiethocphiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Lophoc;
use app\models\Diemdanhhocsinh;

/**
 * QuanlytintucController implements the CRUD actions for hocsinh model.
 */
class QuanlytintucController extends Controller
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
     * Lists all hocsinh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TintucSearch();
        $dataProvider = $searchModel->searchtintuctheodonvi(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single hocsinh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new hocsinh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('quanlytintuc')) {
            $model = new Tintuc();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->STATUS = 1;

            if ($model->load(Yii::$app->request->post())) {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save();
                // $log = new ActivitiesLog;
                // $log->activity_type = 'unit-add';
                // $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm đơn vị ". $model->MA_LOP;
                // $log->user_id = Yii::$app->user->identity->id;
                // $log->create_at = time();
                // $log->save();
                Yii::$app->session->setFlash('success', "Thêm mới thành công!");
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Updates an existing hocsinh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('quanlytintuc') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing hocsinh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->getDsdiemdanh()->andWhere(['STATUS' => 1])->count() && Yii::$app->user->can('quanlyhocsinh') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            Diemdanhhocsinh::deleteAll(['ID_HOCSINH' => $id]);
            $model->delete();
            Yii::$app->session->setFlash('success', "Xóa học sinh thành công!");
            return $this->redirect(['/lophoc/quanlyhocsinh', 'id' => $model->ID_LOP]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Finds the hocsinh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return hocsinh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tintuc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
