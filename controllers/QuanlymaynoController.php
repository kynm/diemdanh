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
                $listTram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['ID_DAI' => $params['TramvtSearch']['ID_DAI']])->orderBy(['TEN_TRAM' => SORT_ASC])->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM');
            } else {
                $listTram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->orderBy(['TEN_TRAM' => SORT_ASC])
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
            Yii::$app->session->setFlash('success', "Xóa dữ liệu thành công");
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
                Yii::$app->session->setFlash('success', "Sửa dữ liệu thành công");
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
            $model->THOIGIANBATDAU = date('Y-m-d H:i');
            $model->THOIGIANKETTHUC = date('Y-m-d H:i');
            $model->ID_NV_DIEUHANH = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->ID_NV_VANHANH = $thietbitram->iDTRAM->ID_NHANVIEN;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($model->THOIGIANBATDAU < date('Y-m-d H:i',strtotime("-9 days"))) {
                    Yii::$app->session->setFlash('error', "Thời gian cập nhật quá 9 ngày. Hãy liên hệ với admin để được xử lý");
                    return $this->redirect(['update', 'id' => $id]);
                }

                $log = new ActivitiesLog;
                $log->activity_type = 'add-nkmayno';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã yêu cầu sử dụng máy nổ";
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                Yii::$app->session->setFlash('success', "Nhập dữ liệu thành công");
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
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
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
            $searchModel = new NhatKySuDungMayNoSearch();
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
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
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
            $searchModel = new NhatKySuDungMayNoSearch();
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
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
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
                $danhsachtram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['in', 'ID_DAI', $dsdai])->all(), 'ID_TRAM', 'ID_TRAM');
                $query = NhatKySuDungMayNo::find();
                $query->where(['in','ID_TRAM', $danhsachtram]);
                $query->andWhere(['LOAINHIENLIEU' => $model->LOAI_NHIENLIEU]);
                $query->andWhere('year(THOIGIANBATDAU) = ' . $model->NAM);
                $query = $query->andWhere('MONTH(THOIGIANBATDAU) = ' . $model->THANG);
                foreach ($query->all() as $key => $value) {
                    $value->GIATIEN = $model->DONGIA;
                    $value->IS_CHECKED = 1;
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

    public function actionUpdategianhienlieu($ID)
    {
        if (Yii::$app->user->can('create-gianhienlieu') || 1) {
            $model = Dongiamayno::findOne($ID);
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
                $danhsachtram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['in', 'ID_DAI', $dsdai])->all(), 'ID_TRAM', 'ID_TRAM');
                $query = NhatKySuDungMayNo::find();
                $query->where(['in','ID_TRAM', $danhsachtram]);
                $query->andWhere(['LOAINHIENLIEU' => $model->LOAI_NHIENLIEU]);
                $query->andWhere('year(THOIGIANBATDAU) = ' . $model->NAM);
                $query = $query->andWhere('MONTH(THOIGIANBATDAU) = ' . $model->THANG);
                foreach ($query->all() as $key => $value) {
                    $value->GIATIEN = $model->DONGIA;
                    $value->IS_CHECKED = 1;
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

            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                ini_set('max_execution_time', 0);                
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                $thietbichuanhap = [];
                foreach ($data as $key => $value) {
                    $tramvt = Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['TEN_TRAM' => $value['ID_TRAM']])->one();
                    # code...
                    $model = new NhatKySuDungMayNo();
                    $model->IS_CHECKED = false;
                    $model->LOAI_SU_CO = 1;
                    $model->ID_NV_DIEUHANH = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $model->ID_NV_VANHANH = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $model->USER_ID = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $model->ID_TRAM = $tramvt ? $tramvt->ID_TRAM : 134;
                    $model->DINHMUC = $value['DINHMUC'];
                    $model->LOAINHIENLIEU = $value['LOAINHIENLIEU'];
                    $model->GIATIEN = 0;
                    $model->THOIGIANBATDAU = date('Y-m-d H:i:s', strtotime($value['THOIGIANBATDAU']));
                    $model->THOIGIANKETTHUC = date('Y-m-d H:i:s', strtotime($value['THOIGIANKETTHUC']));
                    $thietbi = Thietbi::find()->where(['TEN_THIETBI' => $value['ID_THIETBITRAM']])->one();
                    $model->ID_THIETBITRAM = 1611;
                    if ($thietbi && $tramvt) {
                        $thietbitram = Thietbitram::find()->where(['ID_TRAM' => $tramvt->ID_TRAM, 'ID_LOAITB' => $thietbi->ID_THIETBI])->one();
                        if ($thietbitram) {
                            $model->ID_THIETBITRAM = $thietbitram->ID_THIETBI;
                        } else {

                        }
                    }
                    $model->save(false);
                }
                die(var_dump($thietbichuanhap));
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            }

            return $this->render('import', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionBaocaotonghoptheodv()
    {
        if (Yii::$app->user->can('bctonghop-mayno')) {
            $years = [
                date('Y') - 1 => date('Y') - 1,
                date('Y') => date('Y'),
            ];
            $params = Yii::$app->request->queryParams;
            if (!$params || !isset($params['NAM'])) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'NAM' => date('Y'),
                    'THANG' => date('m'),
                ]);
            }
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
            }
            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            $tongnhienlieu = [];
            $searchModel = new NhatKySuDungMayNoSearch();
            $color = ["red","green","blue","yellow","brown","#00FFFF","#8B008B","#2F4F4F","#696969"];
            $i = 0;
            foreach ($dsdonvi as $key => $value) {
                $tongnhienlieu[$key] = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                ];
                $tongnhienlieu[$key]['TEN_DONVI'] = $value;
                $tongnhienlieu[$key]['COLOR'] = $color[$i];
                $i++;
                $dulieutonghop = $searchModel->baocaotonghoptheothang(['NAM' => $params['NAM'], 'ID_DONVI' => $key]);
                foreach ($dulieutonghop as $v) {
                    $tongnhienlieu[$key][$v['THANG']] = $v['TONG_THOI_GIAN'];
                }
            }

            $tonghoptrongthang = [];
            $i = 0;
            $labels = [];
            for($j = 0; $j <  date('t'); $j++)
            {
               $labels[] =  'Ngày ' . ($j + 1);
            }
            foreach ($dsdonvi as $key => $value) {
                $tonghoptrongthang[$key] = [];
                for($j = 0; $j <  date('t'); $j++)
                {
                   $tonghoptrongthang[$key][$j] =  0;
                }
                $tonghoptrongthang[$key][30] =  0;
                $tonghoptrongthang[$key]['TEN_DONVI'] = $value;
                $tonghoptrongthang[$key]['COLOR'] = $color[$i];
                $i++;
                $dulieutonghop = $searchModel->baocaotonghoptrongthang(['NAM' => $params['NAM'], 'THANG' => $params['THANG'], 'ID_DONVI' => $key ]);
                foreach ($dulieutonghop as $v) {
                    $tonghoptrongthang[$key][$v['NGAY'] - 1] = $v['TONG_THOI_GIAN'];
                }
            }

            return $this->render('tonghoptheodonvi', [
                    'tongnhienlieu' => $tongnhienlieu,
                    'tonghoptrongthang' => $tonghoptrongthang,
                    'labels' => $labels,
                    'params' => $params,
                    'years' => $years,
                    'months' => $months,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionBaocaodaitram()
    {
        $searchModel = new NhatKySuDungMayNoSearch();
        $dataProvider = $searchModel->searchbaocaodaitram(Yii::$app->request->queryParams);
        return $this->render('baocaodaitram', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBaocaotonghoptheotram()
    {
        if (Yii::$app->user->can('bctonghop-mayno')) {
            $params = Yii::$app->request->queryParams;
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }

            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            if (!$params) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'LOAIBC' => 'THOIGIAN',
                    'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI
                ]);
            } else {
                $iddv = $params['ID_DONVI'] ? $params['ID_DONVI'] : $iddv;
            }

            $params['is_excel'] = $params['is_excel'] ?? null;
            $dmloaibc = ['THOIGIAN' => 'Báo cáo theo thời gian', 'SOLUONG' => 'Báo cáo theo số lượng (lít)', 'TONGTIEN' => 'Báo cáo theo tổng tiền'];
            $loaibc = $params['LOAIBC'];
            $dsdai = ArrayHelper::map(Daivt::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DAI', 'ID_DAI');
            // $dstram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['in', 'ID_TRAM', $iddv])->all(), 'ID_TRAM', 'TEN_TRAM');
            $dstram = Tramvt::find()->andWhere(['in', 'ID_DAI', $dsdai])->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->all();
            
            $data = [];
            $searchModel = new NhatKySuDungMayNoSearch();
            foreach ($dstram as $key => $value) {
                $data[$value->ID_TRAM] = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                ];
                $data[$value->ID_TRAM]['TEN_TRAM'] = $value->TEN_TRAM;
                $data[$value->ID_TRAM]['DIADIEM'] = $value->DIADIEM;
                foreach ($searchModel->tonghoptheotram($value->ID_TRAM, date('Y'), $loaibc) as $v) {
                    $data[$value->ID_TRAM][$v['THANG']] = $v['TONG'];
                }
            }
            if ($params['is_excel']) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->fromArray(
                    [
                        'STT',
                        'Tên đơn vị',
                        'Địa chỉ',
                        'Tháng 1',
                        'Tháng 2',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 3',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 4',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 5',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 6',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 7',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 8',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 9',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 10',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 11',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 12',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                    ],
                    '',
                    'A1'         
                );
                $key = 0;
                $x = 2;
                foreach ($data as $value) {
                    $chenh21 = $value[2] - $value[1];
                    $chenh32 = $value[3] - $value[2];
                    $chenh43 = $value[4] - $value[3];
                    $chenh54 = $value[5] - $value[4];
                    $chenh65 = $value[6] - $value[5];
                    $chenh76 = $value[7] - $value[6];
                    $chenh87 = $value[8] - $value[7];
                    $chenh98 = $value[9] - $value[8];
                    $chenh109 = $value[10] - $value[9];
                    $chenh1110 = $value[11] - $value[10];
                    $chenh1211 = $value[12] - $value[11];
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", ($key + 1))
                        ->setCellValue("B$x", $value['TEN_TRAM'])
                        ->setCellValue("C$x", $value['DIADIEM'])
                        ->setCellValue("D$x", formatnumber($value[1]))
                        ->setCellValue("E$x", formatnumber($value[2]))
                        ->setCellValue("F$x", $chenh21 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("G$x", $chenh21)
                        ->setCellValue("H$x", $value[1] != 0 ? formatnumber($chenh21/$value[1] * 100, 2): 0)
                        ->setCellValue("I$x", formatnumber($value[3]))
                        ->setCellValue("J$x", $chenh32 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("K$x", $chenh32)
                        ->setCellValue("L$x", $value[2] != 0 ? formatnumber($chenh32/$value[2] * 100, 2): 0)
                        ->setCellValue("M$x", formatnumber($value[4]))
                        ->setCellValue("N$x", $chenh43 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("O$x", $chenh43)
                        ->setCellValue("P$x", $value[3] != 0 ? formatnumber($chenh43/$value[3] * 100, 2): 0)
                        ->setCellValue("Q$x", formatnumber($value[5]))
                        ->setCellValue("R$x", $chenh54 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("S$x", $chenh54)
                        ->setCellValue("T$x", $value[4] != 0 ? formatnumber($chenh54/$value[4] * 100, 2): 0)
                        ->setCellValue("U$x", formatnumber($value[6]))
                        ->setCellValue("V$x", $chenh65 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("W$x", $chenh65)
                        ->setCellValue("X$x", $value[5] != 0 ? formatnumber($chenh65/$value[5] * 100, 2): 0)
                        ->setCellValue("Y$x", formatnumber($value[7]))
                        ->setCellValue("Z$x", $chenh76 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AA$x", $chenh76)
                        ->setCellValue("AB$x", $value[6] != 0 ? formatnumber($chenh76/$value[6] * 100, 2): 0)
                        ->setCellValue("AC$x", formatnumber($value[8]))
                        ->setCellValue("AD$x", $chenh87 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AE$x", $chenh87)
                        ->setCellValue("AF$x", $value[7] != 0 ? formatnumber($chenh87/$value[7] * 100, 2): 0)
                        ->setCellValue("AG$x", formatnumber($value[9]))
                        ->setCellValue("AH$x", $chenh98 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AI$x", $chenh98)
                        ->setCellValue("AJ$x", $value[8] != 0 ? formatnumber($chenh98/$value[8] * 100, 2): 0)
                        ->setCellValue("AK$x", formatnumber($value[10]))
                        ->setCellValue("AL$x", $chenh109 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AM$x", $chenh109)
                        ->setCellValue("AN$x", $value[9] != 0 ? formatnumber($chenh109/$value[9] * 100, 2): 0)
                        ->setCellValue("AO$x", formatnumber($value[11]))
                        ->setCellValue("AP$x", $chenh1110 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AQ$x", $chenh1110)
                        ->setCellValue("AR$x", $value[10] != 0 ? formatnumber($chenh1110/$value[10] * 100, 2): 0)
                        ->setCellValue("AS$x", formatnumber($value[12]))
                        ->setCellValue("AT$x", $chenh1211 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AU$x", $chenh1211)
                        ->setCellValue("AV$x", $value[11] != 0 ? formatnumber($chenh1211/$value[11] * 100, 2): 0);
                    $key ++;
                    $x ++;
                }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $file_name = "Export_" . $dmloaibc[$loaibc].date('Ymd_His');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save("php://output");
        exit;
            }

            return $this->render('tonghoptheotram', [
                    'data' => $data,
                    'dmloaibc' => $dmloaibc,
                    'dsdonvi' => $dsdonvi,
                    'params' => $params,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionBaocaodinhmucmayno()
    {
        $dsthietbi = ArrayHelper::map(Thietbi::find()->where(['ID_NHOM' => 1])->all(), 'ID_THIETBI', 'ID_THIETBI');
        $dsmayno = Thietbitram::find()->where(['in', 'ID_LOAITB', $dsthietbi])->orderBy('ID_TRAM')->all();
        $datamayno = [];
        $searchModel = new NhatKySuDungMayNoSearch();
        $loainhienlieu = $searchModel->getloainhienlieu();
        foreach ($dsmayno as $key => $value) {
            $thamso = json_decode($value->THAMSOTHIETBI);
            if ($thamso) {
                $datamayno[$value->ID_THIETBI]['dai'] = $value->iDTRAM->iDDAI->TEN_DAIVT;
                $datamayno[$value->ID_THIETBI]['tram'] = $value->iDTRAM->TEN_TRAM;
                $datamayno[$value->ID_THIETBI]['name'] = $value->iDLOAITB->TEN_THIETBI;
                $datamayno[$value->ID_THIETBI]['dinhmuc'] = $thamso->DINH_MUC;
                $datamayno[$value->ID_THIETBI]['loainhienlieu'] = $loainhienlieu[$thamso->LOAINHIENLIEU];
            }
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->fromArray(
            ['Đài viễn thông','Tên trạm','Tên máy nổ', 'Định mức', 'Loại nhiên liệu'],
            '',
            'A1'         
        );
        $sheet->fromArray(
            $datamayno,
            '',
            'A2'
        );
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_name = "Định mức máy nổ_".date('Ymd_His');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save("php://output");
        exit;
    }
}
