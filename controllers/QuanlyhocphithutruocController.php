<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlyhocphithutruoc;
use app\models\Lophoc;
use app\models\Hocsinh;
use app\models\QuanlyhocphithutruocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * HocsinhController implements the CRUD actions for hocsinh model.
 */
class QuanlyhocphithutruocController extends Controller
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
        $searchModel = new QuanlyhocphithutruocSearch();
        $dataProvider = $searchModel->searchhocphithutruoctheodonvi(Yii::$app->request->queryParams);
        $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dslop' => $dslop,
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
        if (Yii::$app->user->can('quanlyhocphi')) {
            $model = new Quanlyhocphithutruoc();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->STATUS = 1;
            if ($model->load(Yii::$app->request->post())) {
                if ($model->getErrors()) {
                    Yii::$app->session->setFlash('error', "Lỗi khởi tạo!");
                    return $this->redirect(['create']);
                }
                $model->save();
                $hocsinh = $model->hocsinh;
                $hocsinh->NGAY_KT = $model->NGAY_KT;
                $hocsinh->save();
                Yii::$app->session->setFlash('success', "Thêm mới thành công!");
                return $this->redirect(['index']);
            } else {
            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('create', [
                    'model' => $model,
                    'dslop' => $dslop,
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
        if (Yii::$app->user->can('edit-hocsinh')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID]);
            } else {
                $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('update', [
                    'model' => $model,
                    'dslop' => $dslop,
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
        if (Yii::$app->user->can('delete-hocsinh')) {
           // $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
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
        if (($model = Hocsinh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function  actionChecksobuoi()
    {
        if (Yii::$app->request->post()) {
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            $params = Yii::$app->request->post();
            $hocsinh = Hocsinh::find(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])
                ->andWhere(['ID_LOP' => $params['lopid']])
                ->andWhere(['ID' => $params['idhocsinh']])
                ->one();
            $sotien = $params['sotien'];
            if (!$hocsinh->TIENHOC) {
                $result = [
                    'error' => 1,
                    'message' => 'CẦN CẬP NHẬT TIỀN HỌC/BUỔI HỌC CHO HỌC SINH!',
                ];
            } else {
                $result = [
                    'error' => null,
                    'message' => 'CẦN CẬP NHẬT TIỀN HỌC/BUỔI HỌC CHO HỌC SINH!',
                    'value' => round($sotien / $hocsinh->TIENHOC, 0),
                ];
            }

            return json_encode($result);
        }
    }
}
