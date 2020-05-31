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
        if (Yii::$app->user->can('import-qldien')) {
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
                Quanlydien::deleteAll([
                                'NAM' => $params['UploadForm']['NAM'],
                                'THANG' => $params['UploadForm']['THANG'],
                            ]);
                foreach ($data as $key => $value) {
                    if ($value['MA_DIENLUC']) {
                        $model1 = new Quanlydien();
                        $model1->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $model1->IS_CHECKED = 1;
                        $model1->MA_DIENLUC = $value['MA_DIENLUC'];
                        $model1->TEN_DIENLUC = $value['TEN_DIENLUC'];
                        $model1->TK_DIENLUC = $value['TK_DIENLUC'];
                        $model1->NH_DIENLUC = $value['NH_DIENLUC'];
                        $model1->MA_CSHT = $value['MA_CSHT'];
                        $model1->MA_DONVIKT = $value['MA_DONVIKT'];
                        $model1->TIENDIEN = (int)$value['TIENDIEN'];
                        $model1->TIENTHUE = (int)$value['TIENTHUE'];
                        $model1->TONGTIEN = (int)$value['TONGTIEN'];
                        $model1->THOIGIANCAPNHAT = date("Y-m-d H:i:s");
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
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionFilemauimportdien()
    {
        if (Yii::$app->user->can('import-qldien')) {
            ini_set('max_execution_time', 5*60); // 5 minutes
            $path = Yii::getAlias('@webroot') . '/samplefile';
            $file = $path . '/dulieudien.xlsx';
            Yii::$app->response->xSendFile($file);  

        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionThongkesudungdien()
    {
        if (Yii::$app->user->can('ketoan-qldien')) {
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = $i;
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            // if (!$params || !isset($params['NAM'])) {
            //     $params = array_merge(Yii::$app->request->queryParams, [
            //         'NAM' => date('Y', strtotime("-1 month")),
            //         'THANG' => date('m', strtotime("-1 month")),
            //         'ID_DONVI' => Donvi::findone(Yii::$app->user->identity->nhanvien->ID_DONVI)->MA_DONVIKT
            //     ]);
            // }

            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }

            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'TEN_DONVI');
            $searchModel = new QuanlydienSearch();
            $dataProvider = $searchModel->searchThongkedien(Yii::$app->request->queryParams);
            return $this->render('thongkesudungdien', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dsdonvi' => $dsdonvi,
                'months' => $months,
                'years' => $years,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionBaocaototrinh()
    {
        if (Yii::$app->user->can('ketoan-qldien')) {
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
            if (!$params || !isset($params['NAM'])) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'NAM' => date('Y', strtotime("-0 month")),
                    'THANG' => date('m', strtotime("-0 month")),
                    'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI
                ]);
            }

            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $inputs['ID_DONVI'] = Yii::$app->user->identity->nhanvien->ID_DONVI;
                $iddv = [$inputs['ID_DONVI']];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            return $this->render('baocaototrinh', [
                'dsdonvi' => $dsdonvi,
                'years' => $years,
                'months' => $months,
                'params' => $params,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionInbaocaototrinhthang()
    {
        if (Yii::$app->user->can('ketoan-qldien')) {
            $params = Yii::$app->request->queryParams;
            $iddv = $params['ID_DONVI'] ? $params['ID_DONVI'] : [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [$params['ID_DONVI']];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'MA_DONVIKT');
            $params['dsdonvi'] = implode(',', $dsdonvi);
            $searchModel = new QuanlydienSearch();
            $dssddien = $searchModel->baocaodsdientheodonvi($params);
            $tongdiendv = $searchModel->baocaothdientheodonvi($params);
            $tongdiennh = $searchModel->baocaothdientheonganhang($params);
            $donvi = Donvi::findOne($params['ID_DONVI']);
            if (isset($params['is_excel']) && $params['is_excel']) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'I - Chi tiết tiền điện theo từng trạm');
                $sheet->setCellValue('B1', $donvi->TEN_DONVI);
                $sheet->fromArray(
                    ['Mã khách hàng trên hóa đơn điện','Mã CSHT','Số tiền chưa thuế','Thuế VAT','Tổng tiền','Tên đơn vị hưởng','Số tài khoản','Tại ngân hàng'],
                    '',
                    'A2'
                );
                $sheet->fromArray(
                    $dssddien,
                    '',
                    'A3'
                );

                $sheet->setCellValue('A' . (count($dssddien) + 3), 'Số liệu tổng hợp ');
                $sheet->fromArray(
                    ['Tên đơn vị hưởng','Số tài khoản','Số tiền chưa thuế','Thuế VAT','Tổng tiền','Tên đơn vị hưởng','Số tài khoản','Tại ngân hàng'],
                    '',
                    'A' . (count($dssddien) + 4)
                );
                $sheet->fromArray(
                    $tongdiennh,
                    '',
                    'A' . (count($dssddien) + 5)
                );
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = 'Số liệu điện '  . $donvi->TEN_DONVI . $params['THANG'] . '/' . $params['NAM'];

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save("php://output");
                exit;
            }
            $this->layout = 'printLayout';
            return $this->render('inbaocaototrinhthang', [
                'dssddien' => $dssddien,
                'tongdiendv' => $tongdiendv,
                'tongdiennh' => $tongdiennh,
                'donvi' => $donvi,
                'inputs' => $params,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }
}
