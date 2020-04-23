<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Dongiamayno;
use app\models\DongiamaynoSearch;
use app\models\NhatKySuDungMayNo;
use app\models\NhatKySuDungMayNoSearch;
use app\models\Tramvt;
use app\models\Donvi;
use app\models\TramvtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use moonland\phpexcel\Excel;

/**
 * TramvtController implements the CRUD actions for Tramvt model.
 */
class QuanlymaynoController extends Controller
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

    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }
    
    /**
     * Lists all Tramvt models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('view-nkmayno')) {
            $searchModel = new TramvtSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->searchMayno($params);
            if (isset($params['TramvtSearch']) && $params['TramvtSearch']['ID_DAI']) {
                $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => $params['TramvtSearch']['ID_DAI']])->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM');
            } else {
                $listTram = ArrayHelper::map(Tramvt::find()->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM');
            }

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'listTram' => $listTram,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Displays a single Tramvt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ThietbitramSearch();
        $dataProvider = $searchModel->searchmaynoTram(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeletenhatky($id)
    {
        if (Yii::$app->user->can('delete-nkmayno')) {
            NhatKySuDungMayNo::findOne($id)->delete();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionUpdatenhatky($id)
    {
        if (Yii::$app->user->can('edit-nkmayno')) {
            $model = NhatKySuDungMayNo::findOne($id);
            $thietbitram = Thietbitram::findOne($model->ID_THIETBITRAM);
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-update';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã yêu cầu sử dụng máy nổ";
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['update', 'id' => $model->ID_THIETBITRAM]);
            } else {
                return $this->render('updatenhatky', [
                    'model' => $model,
                    'thietbitram' => $thietbitram,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    /**
     * Updates an existing Tramvt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('add-nkmayno')) {
            $model = new NhatKySuDungMayNo();
            $thietbitram = Thietbitram::findOne($id);
            $model->ID_TRAM = $thietbitram->ID_TRAM;
            $model->IS_CHECKED = true;
            $model->LOAI_SU_CO = 1;
            $model->ID_NV_DIEUHANH = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->ID_NV_VANHANH = $thietbitram->iDTRAM->ID_NHANVIEN;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'add-nkmayno';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã yêu cầu sử dụng máy nổ";
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['update', 'id' => $id]);
            } else {
                $searchModel = new NhatKySuDungMayNoSearch();
                $params = Yii::$app->request->queryParams;
                $params['ID_THIETBITRAM'] = $thietbitram->ID_THIETBI;
                $dataProvider = $searchModel->search($params);
                return $this->render('update', [
                    'model' => $model,
                    'thietbitram' => $thietbitram,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionThongkeketoan()
    {
        if (Yii::$app->user->can('tkkt-mayno')) {
            $months = [];
            $data = [];
            $inputs = [
                'ID_DONVI' => 2,
                'THANG' => date('m'),
                'NAM' => date('Y'),
            ];
            $dongiamayno = [
                1 => 0,
                2 => 0,
            ];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $isprint = 0;
            if (Yii::$app->request->post()) {
                $isprint = 1;
                $inputs = Yii::$app->request->bodyParams;
                $dongiamayno = ArrayHelper::map(Dongiamayno::find()
                    ->where(['THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']])->all(), 'LOAI_NHIENLIEU', 'DONGIA');
                $dsdai = ArrayHelper::map(Daivt::find()->where(['ID_DONVI' => $inputs['ID_DONVI']])->all(), 'ID_DAI', 'ID_DAI');
                $danhsachtram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_DAI', $dsdai])->all(), 'ID_TRAM', 'ID_TRAM');
                $query = NhatKySuDungMayNo::find();
                $query->joinWith('tHIETBITRAM')->where(['in','tHIETBITRAM.ID_TRAM', $danhsachtram]);
                $query->andWhere('year(THOIGIANBATDAU) = ' . $inputs['NAM']);
                $query->andWhere('MONTH(THOIGIANBATDAU) = ' . $inputs['THANG']);
                
                $data = $query->all();
            }
            return $this->render('thongkeketoan', [
                'isprint' => $isprint,
                'data' => $data,
                'months' => $months,
                'years' => $years,
                'inputs' => $inputs,
                'dongiamayno' => $dongiamayno,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionInbaoduongthang()
    {
        if (Yii::$app->user->can('tkkt-mayno')) {
            $this->layout = 'printLayout';
            $months = [];
            $data = [];
            $inputs = [
                'ID_DONVI' => 2,
                'THANG' => date('m'),
                'NAM' => date('Y'),
            ];
            $dongiamayno = [
                1 => 0,
                2 => 0,
            ];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $inputs = Yii::$app->request->get();
            $dongiamayno = ArrayHelper::map(Dongiamayno::find()
                ->where(['THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']])->all(), 'LOAI_NHIENLIEU', 'DONGIA');
            $dsdai = ArrayHelper::map(Daivt::find()->where(['ID_DONVI' => $inputs['ID_DONVI']])->all(), 'ID_DAI', 'ID_DAI');
            $danhsachtram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_DAI', $dsdai])->all(), 'ID_TRAM', 'ID_TRAM');
            $query = NhatKySuDungMayNo::find();
            $query->joinWith('tHIETBITRAM')->where(['in','tHIETBITRAM.ID_TRAM', $danhsachtram]);
            $query->andWhere('year(THOIGIANBATDAU) = ' . $inputs['NAM']);
            $query->andWhere('MONTH(THOIGIANBATDAU) = ' . $inputs['THANG']);
            $donvi = Donvi::findOne($inputs['ID_DONVI']);
            $data = $query->all();
            return $this->render('inbaoduongthang', [
                'data' => $data,
                'dongiamayno' => $dongiamayno,
                'donvi' => $donvi,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    protected function findModel($id)
    {
        if (($model = Tramvt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreategianhienlieu()
    {
        if (Yii::$app->user->can('create-gianhienlieu') || 1) {
            $model = new Dongiamayno();
            $log = new ActivitiesLog;

            if ($model->load(Yii::$app->request->post()))
            {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;
                $oldGia = Dongiamayno::find()->where(['THANG' => $model->THANG, 'NAM' => $model->NAM, 'LOAI_NHIENLIEU' => $model->LOAI_NHIENLIEU])->one();
                if ($oldGia) {
                    $oldGia->DONGIA = $model->DONGIA;
                    $oldGia->save();
                    $log->activity_type = 'update_dongia';
                } else {
                    $model->save();
                    $log->activity_type = 'add_dongia';
                }
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." thêm đơn giá cho ". $model->ID;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['gianhienlieu']);
            } else {
                return $this->render('giamayno', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionGianhienlieu()
    {
        $searchModel = new DongiamaynoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('dongianhienlieu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
