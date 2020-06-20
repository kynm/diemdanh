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

            $iddv = [2,3,4,5,6,7,666];
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'listTram' => $listTram,
                'iddv' => $iddv,
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
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
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
            if ($model->load(Yii::$app->request->post()))
            {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save(false);
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            }
            return $this->render('update', [
                'model' => $model,
                'tramvt' => $tramvt,
            ]);
        } else {
            throw new ForbiddenHttpException('Trạm chưa liên kết đến điện lực');
        }
    }

    public function actionUpdatedinhmucdien($id)
    {
        if (Yii::$app->user->can('capnhatdinhmuc-qldien')) {
            $model = Quanlydien::findOne($id);
            $inputs = Yii::$app->request->bodyParams;
            $model->DINHMUC = $inputs['DINHMUC'];
            if ($model->save(false))
            {
                return json_encode([
                    "message" => "Thêm định mức thành công",
                    "error" => false
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode([
                        "message" => "Lỗi dữ liệu",
                        "error" => true
                    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
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
            $years = [];
            for ($i = 0; $i <= 1; $i++) {
                $months[date('m', strtotime("-$i month"))] = date('m', strtotime("-$i month"));
                $years[date('Y', strtotime("-$i month"))] = date('Y', strtotime("-$i month"));
            }
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
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
                $keys = array_keys($data[0]);
                $arrkeyCheck = ['MA_DIENLUC', 'TEN_DIENLUC', 'TK_DIENLUC', 'NH_DIENLUC', 'MA_CSHT', 'TIENDIEN', 'TIENTHUE', 'TONGTIEN', 'KW_TIEUTHU'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['import']);
                }
                Quanlydien::deleteAll([
                                'NAM' => $params['UploadForm']['NAM'],
                                'THANG' => $params['UploadForm']['THANG'],
                                'MA_DONVIKT' => $params['UploadForm']['MA_DONVIKT'],
                                'IS_CHECKED' => NULL,
                            ]);
                foreach ($data as $key => $value) {
                    if ($value['MA_DIENLUC']) {
                        $model1 = new Quanlydien();
                        $model1->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $model1->IS_CHECKED = NULL;
                        $model1->MA_DIENLUC = $value['MA_DIENLUC'];
                        $model1->TEN_DIENLUC = $value['TEN_DIENLUC'];
                        $model1->TK_DIENLUC = $value['TK_DIENLUC'];
                        $model1->NH_DIENLUC = $value['NH_DIENLUC'];
                        $model1->MA_CSHT = $value['MA_CSHT'];
                        $model1->MA_DONVIKT = $params['UploadForm']['MA_DONVIKT'];
                        $model1->TIENDIEN = (int)$value['TIENDIEN'];
                        $model1->TIENTHUE = (int)$value['TIENTHUE'];
                        $model1->TONGTIEN = (int)$value['TONGTIEN'];
                        $model1->KW_TIEUTHU = (int)$value['KW_TIEUTHU'];
                        $model1->THOIGIANCAPNHAT = date("Y-m-d H:i:s");
                        $model1->NAM = $params['UploadForm']['NAM'];
                        $model1->THANG = $params['UploadForm']['THANG'];
                        $model1->save(false);
                    }
                }
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

    public function actionFilemauimportdien()
    {
        if (Yii::$app->user->can('import-qldien')) {
            ini_set('max_execution_time', 5*60); // 5 minutes
            $path = Yii::getAlias('@webroot') . '/samplefile';
            $file = $path . '/dulieudien.xlsx';
            return Yii::$app->response->xSendFile($file);

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
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
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
                $months[date('m', strtotime( date( 'Y-01-01' )." +$i months"))] = date('m', strtotime( date( 'Y-01-01' )." +$i months"));
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

            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
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
            $params['is_excel'] = $params['is_excel'] ?? null;
            $params['IS_CHECKED'] = $params['IS_CHECKED'] ?? null;
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
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
            if ($params['is_excel']) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->mergeCells("A1:B1")->mergeCells("C1:F1")->mergeCells("G1:K1")
                    ->setCellValue("A1", "VNPT HÀ NAM")
                    ->setCellValue("G1", "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
                $spreadsheet->getActiveSheet()->mergeCells("A2:B2")->mergeCells("C2:F2")->mergeCells("G2:K2")
                    ->setCellValue("A2", "Phòng Kế toán Kế hoạch")
                    ->setCellValue("G2", "Độc lập - Tự do - Hạnh phúc");
                $spreadsheet->getActiveSheet()->mergeCells("A4:K4")->setCellValue("A4", "TỜ TRÌNH");
                $spreadsheet->getActiveSheet()->mergeCells("A5:K5")
                    ->setCellValue("A5", "V/v: Thanh toán tiền điện cho  các Trung tâm Viễn thông huyện, thành phố tháng: " .  $params["THANG"] . "/" . $params["NAM"]);
                $spreadsheet->getActiveSheet()->mergeCells("A7:K7")->setCellValue("A7", "Kính gửi: Giám đốc Viễn thông Hà Nam");
                $spreadsheet->getActiveSheet()->mergeCells("A8:K8")->setCellValue("A8", "Ý KIẾN CỦA LÃNH ĐẠO");

                $spreadsheet->getActiveSheet()->getStyle('A1:K8')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->mergeCells("A10:K10")->setCellValue("A10", "Căn cứ các hợp đồng giữa Trung tâm viễn thông huyện thành phố và điện lực địa phương");
                $spreadsheet->getActiveSheet()->mergeCells("A11:K11")->setCellValue("A11", "Căn cứ hóa đơn tiền điện phát sinh tháng 5/2020 tại đơn vị ");
                $spreadsheet->getActiveSheet()->mergeCells("A12:K12")->setCellValue("A12", "Căn cứ tờ trình về việc thanh toán tiền điện tháng 5/2020 của đơn vị. ");
                $spreadsheet->getActiveSheet()->mergeCells("A13:K13")->setCellValue("A13", "Để kịp thời thanh toán tiền điện cho điện lực địa phương; kính trình Giám đốc Viễn thông Hà Nam thanh toán tập trung tại Viễn thông Hà Nam các hóa đơn tiền điện chi  tiết như sau:");
                $spreadsheet->getActiveSheet()->mergeCells("A15:K15")->setCellValue("A15", "I. Tổng hợp tiền điện theo trung tâm viễn thông");
                if (count($tongdiendv)) {
                    $tongchuathue = 0;
                    $tongthue = 0;
                    $tongtien = 0;
                    $tongdv = 0;
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A16", 'STT')
                        ->setCellValue("B16", 'Tên TTVT')
                        ->setCellValue("C16", 'Số trạm thanh toán')
                        ->setCellValue("D16", 'Số tiền chưa thuế')
                        ->setCellValue("E16", 'Thuế VAT')
                        ->setCellValue("F16", 'Tổng tiền')
                        ->setCellValue("G16", 'Tiền đề nghị thanh toán');
                    foreach($tongdiendv as $key => $value) {
                        $tongchuathue += $value['TIENDIEN'];
                        $tongthue += $value['TIENTHUE'];
                        $tongtien += $value['TONGTIEN'];
                        $tongdv += $value['SO_TRAM'];
                        $x = $key + 17;
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue("A$x", ($key + 1))
                            ->setCellValue("B$x", $value['TEN_DONVI'])
                            ->setCellValue("C$x", $value['SO_TRAM'])
                            ->setCellValue("D$x", formatnumber($value['TIENDIEN']))
                            ->setCellValue("E$x", formatnumber($value['TIENTHUE']))
                            ->setCellValue("F$x", formatnumber($value['TONGTIEN']))
                            ->setCellValue("G$x", formatnumber($value['TONGTIEN']));
                    }

                    $x++;
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", 'Tổng')
                        ->setCellValue("B$x", '')
                        ->setCellValue("C$x", formatnumber($tongdv))
                        ->setCellValue("D$x", formatnumber($tongchuathue))
                        ->setCellValue("E$x", formatnumber($tongthue))
                        ->setCellValue("F$x", formatnumber($tongtien))
                        ->setCellValue("G$x", '');
                    $x++;
                    $x++;
                    $spreadsheet->getActiveSheet()->mergeCells("A$x:K$x")->setCellValue("A$x", 'II. Tổng hợp tiền điện theo số tài khoản');
                    $x++;
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", 'STT')
                        ->setCellValue("B$x", 'Tên đơn vị hưởng')
                        ->setCellValue("C$x", 'Số tài khoản')
                        ->setCellValue("D$x", 'Số tiền chưa thuế')
                        ->setCellValue("E$x", 'Thuế VAT')
                        ->setCellValue("F$x", 'Tổng tiền')
                        ->setCellValue("G$x", 'Tại ngân hàng');
                    //list danh sách
                    $tongchuathue = 0;
                    $tongthue = 0;
                    $tongtien = 0;
                    foreach($tongdiennh as $key => $value) {
                        $tongchuathue += $value['T_TIENDIEN'];
                        $tongthue += $value['T_TIENTHUE'];
                        $tongtien += $value['T_TONGTIEN'];
                        $x = count($tongdiendv) + $key + 21;
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue("A$x", ($key + 1))
                            ->setCellValue("B$x", $value['TEN_DIENLUC'])
                            ->setCellValue("C$x", $value['TK_DIENLUC'])
                            ->setCellValue("D$x", $value['T_TIENDIEN'])
                            ->setCellValue("E$x", $value['T_TIENTHUE'])
                            ->setCellValue("F$x", $value['T_TONGTIEN'])
                            ->setCellValue("G$x", $value['NH_DIENLUC']);
                        $spreadsheet->getActiveSheet()->getStyle("C$x")->getNumberFormat()->setFormatCode('0');
                    }

                    $x++;
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", 'Tổng')
                        ->setCellValue("B$x", '')
                        ->setCellValue("C$x", '')
                        ->setCellValue("D$x", formatnumber($tongchuathue))
                        ->setCellValue("E$x", formatnumber($tongthue))
                        ->setCellValue("F$x", formatnumber($tongtien))
                        ->setCellValue("G$x", '');

                    $x++;
                    $x++;
                    $spreadsheet->getActiveSheet()->mergeCells("A$x:K$x")->setCellValue("A$x", 'III. Chi tiết tiền điện theo từng trạm');
                    $x++;
                    $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue("A$x", 'STT')
                            ->setCellValue("B$x", 'Mã khách hàng trên hóa đơn điện')
                            ->setCellValue("C$x", 'Mã CSHT')
                            ->setCellValue("D$x", 'Số tiền chưa thuế')
                            ->setCellValue("E$x", 'Thuế VAT')
                            ->setCellValue("F$x", 'Tổng tiền')
                            ->setCellValue("G$x", 'Tổng tiền đề xuất')
                            ->setCellValue("H$x", 'Tên đơn vị hưởng')
                            ->setCellValue("I$x", 'Số tài khoản')
                            ->setCellValue("J$x", 'Tại ngân hàng')
                            ->setCellValue("K$x", 'Mã đơn vị');
                    foreach($dssddien as $key => $value) {
                        $x = count($tongdiennh) + count($tongdiendv) + $key + 25;
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue("A$x", ($key + 1))
                            ->setCellValue("B$x", $value['MA_DIENLUC'])
                            ->setCellValue("C$x", $value['MA_CSHT'])
                            ->setCellValue("D$x", formatnumber($value['TIENDIEN']))
                            ->setCellValue("E$x", formatnumber($value['TIENTHUE']))
                            ->setCellValue("F$x", formatnumber($value['TONGTIEN']))
                            ->setCellValue("G$x", formatnumber($value['TONGTIEN']))
                            ->setCellValue("H$x", $value['TEN_DIENLUC'])
                            ->setCellValue("I$x", $value['TK_DIENLUC'])
                            ->setCellValue("J$x", $value['NH_DIENLUC'])
                            ->setCellValue("K$x", $value['MA_DONVIKT']);
                        $spreadsheet->getActiveSheet()->getStyle("I$x")->getNumberFormat()->setFormatCode('0');
                    }
                    $x++;
                    $x++;
                    $x++;
                    $x++;
                    $x++;
                    $spreadsheet->getActiveSheet()->mergeCells("A$x:D$x")->setCellValue("A$x", 'Người lập biểu');
                    $spreadsheet->getActiveSheet()->setCellValue("H$x", 'Phủ Lý, ngày ' . date('d') . ', ' . date('m') . ', '. date('Y'));
                    $spreadsheet->getActiveSheet()->getStyle("A$x:K$x")->getAlignment()->setHorizontal('center');
                    $x++;
                    $spreadsheet->getActiveSheet()->mergeCells("A$x:D$x")->setCellValue("A$x", '');
                    $spreadsheet->getActiveSheet()->setCellValue("H$x", 'Kế toán trưởng');
                    $spreadsheet->getActiveSheet()->getStyle("A$x:K$x")->getAlignment()->setHorizontal('center');
                }
                $filename = 'Dữ liệu điện ' . $params["THANG"] . "_" . $params["NAM"] . '.xlsx'; //save our workbook as this file name
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

    public function actionBaocaotonghoptheodv()
    {
        if (Yii::$app->user->can('bctonghop-qldien')) {
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'TEN_DONVI');
            $tongdien = [];
            $searchModel = new QuanlydienSearch();
            $color = ["red","green","blue","yellow","brown","#00FFFF","#8B008B","#2F4F4F","#696969"];
            $i = 0;
            foreach ($dsdonvi as $key => $value) {
                $tongdien[$key] = [
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
                $tongdien[$key]['TEN_DONVI'] = $value;
                $tongdien[$key]['COLOR'] = $color[$i];
                $i++;
                foreach ($searchModel->tonghoptheodonvi($key, date('Y')) as $v) {
                    $tongdien[$key][$v['THANG']] = $v['TONGTIEN'];
                }
            }
            $tongtram = [];
            $i = 0;
            foreach ($dsdonvi as $key => $value) {
                $tongtram[$key] = [
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
                $tongtram[$key]['TEN_DONVI'] = $value;
                $tongtram[$key]['COLOR'] = $color[$i];
                $i++;
                foreach ($searchModel->tonghoptramphatsinhtheodonvi($key, date('Y')) as $v) {
                    $tongtram[$key][$v['THANG']] = $v['TONGTRAM'];
                }
            }
            return $this->render('tonghoptheodonvi', [
                    'tongdien' => $tongdien,
                    'tongtram' => $tongtram,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
        //export excel
        // $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        // $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        // $spreadsheet->getActiveSheet()->mergeCells("A1:B1")->mergeCells("C1:F1")->mergeCells("G1:K1")
        //     ->setCellValue("A1", "VNPT HÀ NAM")
        //     ->setCellValue("G1", "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        // $spreadsheet->getActiveSheet()->mergeCells("A2:B2")->mergeCells("C2:F2")->mergeCells("G2:K2")
        //     ->setCellValue("A2", "Phòng Kế toán Kế hoạch")
        //     ->setCellValue("G2", "Độc lập - Tự do - Hạnh phúc");
        // $spreadsheet->getActiveSheet()->mergeCells("A4:K4")->setCellValue("A4", "TỜ TRÌNH");
        // $spreadsheet->getActiveSheet()->mergeCells("A5:K5")
        //     ->setCellValue("A5", "V/v: Thanh toán tiền điện cho  các Trung tâm Viễn thông huyện, thành phố");
        // $spreadsheet->getActiveSheet()->mergeCells("A7:K7")->setCellValue("A7", "Kính gửi: Giám đốc Viễn thông Hà Nam");
        // $spreadsheet->getActiveSheet()->mergeCells("A8:K8")->setCellValue("A8", "Ý KIẾN CỦA LÃNH ĐẠO");

        // $spreadsheet->getActiveSheet()->getStyle('A1:K8')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("A10:K10")->setCellValue("A10", "Căn cứ các hợp đồng giữa Trung tâm viễn thông huyện thành phố và điện lực địa phương");
        // $spreadsheet->getActiveSheet()->mergeCells("A11:K11")->setCellValue("A11", "Căn cứ hóa đơn tiền điện phát sinh tháng 5/2020 tại đơn vị ");
        // $spreadsheet->getActiveSheet()->mergeCells("A12:K12")->setCellValue("A12", "Căn cứ tờ trình về việc thanh toán tiền điện tháng 5/2020 của đơn vị. ");
        // $spreadsheet->getActiveSheet()->mergeCells("A13:K13")->setCellValue("A13", "Để kịp thời thanh toán tiền điện cho điện lực địa phương; kính trình Giám đốc Viễn thông Hà Nam thanh toán tập trung tại Viễn thông Hà Nam các hóa đơn tiền điện chi  tiết như sau:");
        // $spreadsheet->getActiveSheet()->mergeCells("A15:K15")->setCellValue("A15", "I. Tổng hợp tiền điện theo trung tâm viễn thông");
        // if (count($data)) {
        //     $tongchuathue = 0;
        //     $tongthue = 0;
        //     $tongtien = 0;
        //     $tongdv = 0;
        //     for ($i=1; $i <= 12 ; $i++) { 
        //     $spreadsheet->setActiveSheetIndex(0)
        //         ->setCellValue("A16", 'STT')
        //         ->setCellValue("B16", 'Tên TTVT')
        //         ->setCellValue("C16", 'Số trạm thanh toán')
        //         ->setCellValue("D16", 'Số tiền chưa thuế')
        //         ->setCellValue("E16", 'Thuế VAT')
        //         ->setCellValue("F16", 'Tổng tiền')
        //         ->setCellValue("G16", 'Tiền đề nghị thanh toán');
        //     }

        //     foreach($tongdiendv as $key => $value) {
        //         $tongchuathue += $value['TIENDIEN'];
        //         $tongthue += $value['TIENTHUE'];
        //         $tongtien += $value['TONGTIEN'];
        //         $tongdv += $value['SO_TRAM'];
        //         $x = $key + 17;
        //         $spreadsheet->setActiveSheetIndex(0)
        //             ->setCellValue("A$x", ($key + 1))
        //             ->setCellValue("B$x", $value['TEN_DONVI'])
        //             ->setCellValue("C$x", $value['SO_TRAM'])
        //             ->setCellValue("D$x", formatnumber($value['TIENDIEN']))
        //             ->setCellValue("E$x", formatnumber($value['TIENTHUE']))
        //             ->setCellValue("F$x", formatnumber($value['TONGTIEN']))
        //             ->setCellValue("G$x", formatnumber($value['TONGTIEN']));
        //     }

        //     $x++;
        //     $spreadsheet->setActiveSheetIndex(0)
        //         ->setCellValue("A$x", 'Tổng')
        //         ->setCellValue("B$x", '')
        //         ->setCellValue("C$x", formatnumber($tongdv))
        //         ->setCellValue("D$x", formatnumber($tongchuathue))
        //         ->setCellValue("E$x", formatnumber($tongthue))
        //         ->setCellValue("F$x", formatnumber($tongtien))
        //         ->setCellValue("G$x", '');
        //     $x++;
        //     $x++;
        //     $x++;
        //     $x++;
        //     $x++;
        //     $spreadsheet->getActiveSheet()->mergeCells("A$x:D$x")->setCellValue("A$x", 'Người lập biểu');
        //     $spreadsheet->getActiveSheet()->setCellValue("H$x", 'Phủ Lý, ngày ' . date('d') . ', ' . date('m') . ', '. date('Y'));
        //     $spreadsheet->getActiveSheet()->getStyle("A$x:K$x")->getAlignment()->setHorizontal('center');
        //     $x++;
        //     $spreadsheet->getActiveSheet()->mergeCells("A$x:D$x")->setCellValue("A$x", '');
        //     $spreadsheet->getActiveSheet()->setCellValue("H$x", 'Kế toán trưởng');
        //     $spreadsheet->getActiveSheet()->getStyle("A$x:K$x")->getAlignment()->setHorizontal('center');
        // }
        // $filename = 'Dữ liệu điện ' . $params["THANG"] . "_" . $params["NAM"] . '.xlsx'; //save our workbook as this file name
        // // Redirect output to a client’s web browser (Xlsx)
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // // If you're serving to IE 9, then the following may be needed
        // header('Cache-Control: max-age=1');

        // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('php://output');
        // die();
    }
}
