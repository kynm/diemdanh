<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Hocsinh;
use app\models\HocsinhSearch;
use app\models\DiemdanhhocsinhSearch;
use app\models\ChitiethocphiSearch;
use app\models\QuanlyhocphithutruocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Lophoc;
use app\models\Diemdanhhocsinh;

/**
 * HocsinhController implements the CRUD actions for hocsinh model.
 */
class HocsinhController extends Controller
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
        $searchModel = new HocsinhSearch();
        $dataProvider = $searchModel->searchhocsinhtheodonvi(Yii::$app->request->queryParams);
        $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
        return $this->render('hocsinhtheodonvi', [
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
        $model =$this->findModel($id);
        if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $searchModel = new ChitiethocphiSearch();
            $dataProvider = $searchModel->searchhocphitheohocsinh(Yii::$app->request->queryParams, $id);
            return $this->render('view', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionHocphitheothang($id)
    {
        $model =$this->findModel($id);
        if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $searchModel = new ChitiethocphiSearch();
            $dataProvider = $searchModel->searchhocphitheohocsinh(Yii::$app->request->queryParams, $id);
            return $this->render('hocphitheothang', [
                'model' => $this->findModel($id),
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionHocphithutruoc($id)
    {
        $model =$this->findModel($id);
        if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $searchModel = new QuanlyhocphithutruocSearch();
            $dataProvider = $searchModel->searchhocphitheohocsinh(Yii::$app->request->queryParams, $id);
            return $this->render('hocphithutruoc', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionLichsudiemdanh($id)
    {
        $params = Yii::$app->request->queryParams;
        $model =$this->findModel($id);
        if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date("Y-m-d", strtotime("-1 month"));
            $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
            $searchModel = new DiemdanhhocsinhSearch();
            $result = $searchModel->searchDiemdanhtheohocsinh($params, $id);
            return $this->render('lichsudiemdanh', [
                'model' => $model,
                'result' => $result,
                'params' => $params,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Creates a new hocsinh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-hocsinh')) {
            $model = new Hocsinh();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // $log = new ActivitiesLog;
                // $log->activity_type = 'unit-add';
                // $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm đơn vị ". $model->MA_LOP;
                // $log->user_id = Yii::$app->user->identity->id;
                // $log->create_at = time();
                // $log->save();
                Yii::$app->session->setFlash('success', "Thêm mới thành công!");
                return $this->redirect(['view', 'id' => $model->ID_LOP]);
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
        if (Yii::$app->user->can('quanlyhocsinh') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
                return $this->redirect(['/lophoc/quanlyhocsinh', 'id' => $model->ID_LOP]);
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
        if (($model = Hocsinh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDoitrangthailop() {
        $result = [
            'error' => 1,
            'message' => 'LỖI CẬP NHẬT',
        ];
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $hocsinh = Hocsinh::findOne($params['idhocsinh']);
            if ($hocsinh->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && Yii::$app->user->can('quanlyhocsinh')) {
                $hocsinh->STATUS = $params['STATUS'] ? 1 : 0;
                $hocsinh->save();
                $result = [
                    'error' => 0,
                    'message' => 'CẬP NHẬT THÀNH CÔNG',
                ];
            }
        }

        return json_encode($result);
    }
}
