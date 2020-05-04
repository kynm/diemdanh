<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Tramvt;
use app\models\Quanlydien;
use app\models\QuanlydienSearch;
use app\models\TramvtSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use moonland\phpexcel\Excel;
use yii\web\UploadedFile;

/**
 * TramvtController implements the CRUD actions for Tramvt model.
 */
class QuanlydienController extends Controller
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
        if (Yii::$app->user->can('list-qldien')) {
            $searchModel = new TramvtSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->searchQldien($params);
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

    public function actionNhapdulieudien($MA_DIENLUC)
    {
        $tramvt = Tramvt::find()->where(['MA_DIENLUC' => $MA_DIENLUC])->one();
        if ($tramvt) {
            $model = new Quanlydien();
            $model->MA_DIENLUC = $MA_DIENLUC;
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            if ($model->load(Yii::$app->request->post()))
            {
                // if (Quanlydien::find()->where(['NAM'])) {
                //     # code...
                // }
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save(false);
            }
            $searchModel = new QuanlydienSearch();
            $dataProvider = $searchModel->search(['MA_DIENLUC' => $MA_DIENLUC]);
            return $this->render('nhapdulieudien', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tramvt' => $tramvt,
                'months' => $months,
                'years' => $years,
            ]);
        } else {
            throw new ForbiddenHttpException('Trạm chưa liên kết đến điện lực');
        }
    }

    public function actionUpdate($id)
    {
        $model = Quanlydien::findOne($id);
        $tramvt = $model->tRAMVT;
        if ($tramvt) {
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            if ($model->load(Yii::$app->request->post()))
            {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                // var_dump($model);
                // die();
                // $model->THOIGIANCAPNHAT = now('Y-m-d');
                $model->save(false);
            }
            return $this->render('update', [
                'model' => $model,
                'tramvt' => $tramvt,
                'months' => $months,
                'years' => $years,
            ]);
        } else {
            throw new ForbiddenHttpException('Trạm chưa liên kết đến điện lực');
        }
    }

    public function actionDelete($id)
    {
        if (1) {
            Quanlydien::findOne($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionImport()
    {
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
        }
        $nowY = date("Y");
        $years = [
            $nowY => $nowY,
            $nowY - 1 => $nowY - 1,
        ];
        $model = new UploadForm();
        if (Yii::$app->request->post())
        {
            $params = Yii::$app->request->bodyParams;
            $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
            $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
            foreach ($data as $key => $value) {
                if ($value['MA_DIENLUC']) {
                    $model1 = Quanlydien::find()
                        ->where([
                            'MA_DIENLUC' => $value['MA_DIENLUC'],
                            'NAM' => $params['UploadForm']['NAM'],
                            'THANG' => $params['UploadForm']['THANG'],
                        ])
                        ->one();
                    if (!$model1) {
                        $model1 = new Quanlydien();
                    }
                    $model1->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $model1->IS_CHECKED = 1;
                    $model1->MA_DIENLUC = $value['MA_DIENLUC'];
                    $model1->TIENDIEN = (int)$value['TIENDIEN'];
                    $model1->TIENTHUE = (int)$value['TIENTHUE'];
                    $model1->TONGTIEN = (int)$value['TONGTIEN'];
                    $model1->NAM = $params['UploadForm']['NAM'];
                    $model1->THANG = $params['UploadForm']['THANG'];
                    $model1->save(false);
                }
            }
        }
        return $this->render('import', [
            'months' => $months,
            'years' => $years,
            'model' => $model,
        ]);
    }

    public function actionThongkesudungdien()
    {
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
        }
        $nowY = date("Y");
        $years = [
            $nowY => $nowY,
            $nowY - 1 => $nowY - 1,
        ];
        $params = Yii::$app->request->queryParams;
        if (!$params) {
            $params = [
                'NAM' => $nowY,
                'THANG' => date("m"),
                'ID_DONVI' => ''
            ];
        }
        $searchModel = new QuanlydienSearch();
        $dataProvider = $searchModel->searchThongkedien($params);
        $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
        return $this->render('thongkesudungdien', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dsdonvi' => $dsdonvi,
            'years' => $years,
            'months' => $months,
            'params' => $params,
        ]);
    }
}
