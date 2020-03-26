<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Dongiamayno;
use app\models\NhatKySuDungMayNo;
use app\models\NhatKySuDungMayNoSearch;
use app\models\Tramvt;
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
        $searchModel = new TramvtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-update';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã yêu cầu sử dụng máy nổ";
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['update', 'id' => $id]);
            } else {
                $searchModel = new NhatKySuDungMayNoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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

    public function actionSearch($donvi, $dai)
    {
        if ($donvi == '') {
            $danhsachtram = Tramvt::find()->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
            return;
        }
        if ($dai == "") {
            $danhsachtram = Tramvt::find()->joinWith('iDDAI')->where(['daivt.ID_DONVI' => $donvi])->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
        } else {
            $danhsachtram = Tramvt::find()->where(['ID_DAI' => $dai])->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
        }
        return;
    }

    public function actionThongkeketoan()
    {
        $months = [];
        $data = [];
        $inputs = [
            'ID_DONVI' => 2,
            'THANG' => date('m'),
            'NAM' => date('Y'),
        ];
        $dongiamayno = [];
        for ($i = 0; $i < 12; $i++) {
            $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
        }
        $nowY = date("Y");
        $years = [
            $nowY => $nowY,
            $nowY - 1 => $nowY - 1,
        ];
        if (Yii::$app->request->post()) {
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
            'data' => $data,
            'months' => $months,
            'years' => $years,
            'inputs' => $inputs,
            'dongiamayno' => $dongiamayno,
            ]);
    }

    protected function findModel($id)
    {
        if (($model = Tramvt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
