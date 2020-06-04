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

use app\models\Thietbi;
use app\models\UploadForm;
use yii\web\UploadedFile;
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
                $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => $params['TramvtSearch']['ID_DAI']])->orderBy(['TEN_TRAM' => SORT_ASC])->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM');
            } else {
                $listTram = ArrayHelper::map(Tramvt::find()->orderBy(['TEN_TRAM' => SORT_ASC])
                    ->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM');
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
            $model->IS_CHECKED = false;
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
                'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                'NAM' => date('Y', strtotime("-1 month")),
                'THANG' => date('m', strtotime("-1 month")),
            ];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];

            }
            $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            $isprint = 0;
            $loainhienlieu = [];
            $searchModel = new NhatKySuDungMayNoSearch();
            $loainhienlieu = $searchModel->getloainhienlieu();
            if (Yii::$app->request->post()) {
                $isprint = 1;
                $inputs = Yii::$app->request->bodyParams;
                if ($inputs['ID_DONVI']) {
                    $dldonvi = [$inputs['ID_DONVI'] => $inputs['ID_DONVI']];
                } else {
                    $dldonvi = $dsDonvi;
                }

                foreach ($dldonvi as $idDonvi => $dv) {
                    $data[$idDonvi] = [];
                    $data[$idDonvi]['TEN_DONVI'] = Donvi::findOne($idDonvi)->TEN_DONVI;
                    $data[$idDonvi]['DU_LIEU'] = $searchModel->baocaomaynotheothang(['ID_DONVI' => $idDonvi, 'THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']]);
                }
            }

            return $this->render('thongkeketoan', [
                'isprint' => $isprint,
                'data' => $data,
                'months' => $months,
                'years' => $years,
                'inputs' => $inputs,
                'loainhienlieu' => $loainhienlieu,
                'dsDonvi' => $dsDonvi,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionThongkechitiet()
    {
        if (Yii::$app->user->can('tkct-mayno')) {
            $months = [];
            $data = [];
            $inputs = [
                'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                'NAM' => date('Y', strtotime("-1 month")),
                'THANG' => date('m', strtotime("-1 month")),
            ];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];

            }
            $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            $isprint = 0;
            $loainhienlieu = [];
            $searchModel = new NhatKySuDungMayNoSearch();
            $loainhienlieu = $searchModel->getloainhienlieu();
            if (Yii::$app->request->post()) {
                $isprint = 1;
                $inputs = Yii::$app->request->bodyParams;
                if ($inputs['ID_DONVI']) {
                    $dldonvi = [$inputs['ID_DONVI'] => $inputs['ID_DONVI']];
                } else {
                    $dldonvi = $dsDonvi;
                }

                foreach ($dldonvi as $idDonvi => $dv) {
                    $data[$idDonvi] = [];
                    $data[$idDonvi]['TEN_DONVI'] = Donvi::findOne($idDonvi)->TEN_DONVI;
                    $data[$idDonvi]['DU_LIEU'] = $searchModel->baocaomaynotheothangchitiet(['ID_DONVI' => $idDonvi, 'THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']]);
                }

            }

            return $this->render('thongkechitiet', [
                'isprint' => $isprint,
                'data' => $data,
                'months' => $months,
                'years' => $years,
                'inputs' => $inputs,
                'loainhienlieu' => $loainhienlieu,
                'dsDonvi' => $dsDonvi,
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
                'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                'NAM' => date('Y', strtotime("-1 month")),
                'THANG' => date('m', strtotime("-1 month")),
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
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $inputs['ID_DONVI'] = Yii::$app->user->identity->nhanvien->ID_DONVI;
                $iddv = [$inputs['ID_DONVI']];
            }
            $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            $searchModel = new NhatKySuDungMayNoSearch();
            $dongiamayno = $searchModel->getDongiatheothang($inputs);
            $loainhienlieu = $searchModel->getloainhienlieu();
            if ($inputs['ID_DONVI']) {
                $dldonvi = [$inputs['ID_DONVI'] => $inputs['ID_DONVI']];
            } else {
                $dldonvi = $dsDonvi;
            }

            foreach ($dldonvi as $idDonvi => $dv) {
                $data[$idDonvi] = [];
                $data[$idDonvi]['TEN_DONVI'] = Donvi::findOne($idDonvi)->TEN_DONVI;
                $data[$idDonvi]['DU_LIEU'] = $searchModel->baocaomaynotheothang(['ID_DONVI' => $idDonvi, 'THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']]);
            }
            $donvi = Donvi::findOne($inputs['ID_DONVI']);
            return $this->render('inbaoduongthang', [
                'data' => $data,
                'dongiamayno' => $dongiamayno,
                'donvi' => $donvi,
                'inputs' => $inputs,
                'loainhienlieu' => $loainhienlieu,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionInchitietbaoduongthang()
    {
        if (Yii::$app->user->can('tkct-mayno')) {
            $this->layout = 'printLayout';
            $months = [];
            $data = [];
            $inputs = [
                'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                'NAM' => date('Y', strtotime("-1 month")),
                'THANG' => date('m', strtotime("-1 month")),
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
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $inputs['ID_DONVI'] = Yii::$app->user->identity->nhanvien->ID_DONVI;
                $iddv = [$inputs['ID_DONVI']];
            }
            $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            $searchModel = new NhatKySuDungMayNoSearch();
            $dongiamayno = $searchModel->getDongiatheothang($inputs);
            $loainhienlieu = $searchModel->getloainhienlieu();
            if ($inputs['ID_DONVI']) {
                $dldonvi = [$inputs['ID_DONVI'] => $inputs['ID_DONVI']];
            } else {
                $dldonvi = $dsDonvi;
            }

            foreach ($dldonvi as $idDonvi => $dv) {
                $data[$idDonvi] = [];
                $data[$idDonvi]['TEN_DONVI'] = Donvi::findOne($idDonvi)->TEN_DONVI;
                $data[$idDonvi]['DU_LIEU'] = $searchModel->baocaomaynotheothangchitiet(['ID_DONVI' => $idDonvi, 'THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']]);
            }
            $donvi = Donvi::findOne($inputs['ID_DONVI']);
            return $this->render('inchitietbaoduongthang', [
                'data' => $data,
                'dongiamayno' => $dongiamayno,
                'donvi' => $donvi,
                'inputs' => $inputs,
                'loainhienlieu' => $loainhienlieu,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionExportbaoduongthang()
    {
        $data = [];
        $inputs = Yii::$app->request->get();
        $iddv = [2,3,4,5,6,7,666];
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $inputs['ID_DONVI'] = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $iddv = [$inputs['ID_DONVI']];
        }
        $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
        if ($inputs['ID_DONVI']) {
            $dldonvi = [$inputs['ID_DONVI'] => $inputs['ID_DONVI']];
        } else {
            $dldonvi = $dsDonvi;
        }
        $searchModel = new NhatKySuDungMayNoSearch();
        foreach ($dldonvi as $idDonvi => $dv) {
            $data = array_merge($data,$searchModel->baocaomaynotheothangchitiet(['ID_DONVI' => $idDonvi, 'THANG' => $inputs['THANG'], 'NAM' => $inputs['NAM']]));
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->fromArray(array_keys($data[0]), '', 'A1');
        $spreadsheet->getActiveSheet()->fromArray($data, '', 'A2');

        $filename = 'Dữ liệu máy nổ ' . $inputs["THANG"] . "_" . $inputs["NAM"] . '.xlsx'; //save our workbook as this file name
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        die();
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
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $inputs['ID_DONVI'] = Yii::$app->user->identity->nhanvien->ID_DONVI;
                $iddv = [$inputs['ID_DONVI']];
            }
            $dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            if ($model->load(Yii::$app->request->post()))
            {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;
                $oldGia = Dongiamayno::find()->where(['ID_DONVI' => $model->ID_DONVI,'THANG' => $model->THANG, 'NAM' => $model->NAM, 'LOAI_NHIENLIEU' => $model->LOAI_NHIENLIEU])->one();
                $dsdai = ArrayHelper::map(Daivt::find()->where(['ID_DONVI' => $model->ID_DONVI])->all(), 'ID_DAI', 'ID_DAI');
                $danhsachtram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_DAI', $dsdai])->all(), 'ID_TRAM', 'ID_TRAM');
                $query = NhatKySuDungMayNo::find();
                $query->where(['in','ID_TRAM', $danhsachtram]);
                $query->andWhere(['LOAINHIENLIEU' => $model->LOAI_NHIENLIEU]);
                $query->andWhere('year(THOIGIANBATDAU) = ' . $model->NAM);
                $query = $query->andWhere('MONTH(THOIGIANBATDAU) = ' . $model->THANG);
                foreach ($query->all() as $key => $value) {
                    $value->GIATIEN = $model->DONGIA;
                    $value->save(false);
                }
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
                Yii::$app->session->setFlash('success', "Cập nhật đơn giá thành công");
                return $this->redirect(['gianhienlieu']);
            } else {
                return $this->render('giamayno', [
                    'model' => $model,
                    'dsDonvi' => $dsDonvi,
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
        $loainhienlieu = [];
        return $this->render('dongianhienlieu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImport()
    {
        if (Yii::$app->user->can('import-qldien')) {
            $months = [];
            // for ($i = 0; $i < 2; $i++) {
            //     $months[date('m', strtotime("-$i month"))] = date('m', strtotime("-$i month"));
            // }
            $months[date('m', strtotime("-2 month"))] = date('m', strtotime("-2 month"));
            // $nowY = date("Y");
            $years = [
                date('Y', strtotime("-2 month")) => date('Y', strtotime("-2 month")),
                // $nowY - 1 => $nowY - 1,
            ];
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }

            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'TEN_DONVI');
            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                $thietbichuanhap = [];
                foreach ($data as $key => $value) {
                $thietbi = Thietbi::find()->where(['TEN_THIETBI' => $value['ID_THIETBITRAM']])->one();
                $tramvt = Tramvt::find()->where(['TEN_TRAM' => $value['ID_TRAM']])->one();
                $thietbitram = Thietbitram::find()->where(['ID_TRAM' => $tramvt->ID_TRAM, 'ID_LOAITB' => $thietbi->ID_THIETBI])->one();
                if (!$thietbitram) {
                        $thietbichuanhap[]= $value;
                    # code...
                }
                    // $thietbitram = Thietbitram::find()->where('')
                }
                die(var_dump($thietbichuanhap));
                $keys = array_keys($data[0]);
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            }

            return $this->render('import', [
                'months' => $months,
                'years' => $years,
                'model' => $model,
                'dsdonvi' => $dsdonvi,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }
}
