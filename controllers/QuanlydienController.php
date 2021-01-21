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

    public function actionUpdatetieuthudien($id)
    {
        if (Yii::$app->user->can('capnhattt-qldien')) {
            $model = Quanlydien::findOne($id);
            $inputs = Yii::$app->request->bodyParams;
            $model->KW_TIEUTHU = $inputs['KW_TIEUTHU'];
            if ($model->save(false))
            {
                return json_encode([
                    "message" => "Thêm điện tiêu thụ thành công",
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
            for ($i = 0; $i <= 5; $i++) {
                $months[date('m', strtotime("-$i month"))] = date('m', strtotime("-$i month"));
                $years[date('Y', strtotime("-$i month"))] = date('Y', strtotime("-$i month"));
            }
            if (!isset($months['02'])) {
                $months['02'] = '02';
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

    public function actionCapnhatdinhmuc()
    {
        if (Yii::$app->user->can('dinhmuc-qldien')) {
            $months = [];
            $years = [];
            for ($i = 0; $i <= 5; $i++) {
                $months[date('m', strtotime("-$i month"))] = date('m', strtotime("-$i month"));
                $years[date('Y', strtotime("-$i month"))] = date('Y', strtotime("-$i month"));
            }
            if (!isset($months['02'])) {
                $months['02'] = '02';
            }
            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                $keys = array_keys($data[0]);
                array_push($keys, 'TRANGTHAI');
                $arrkeyCheck = ['MA_CSHT', 'DINHMUC'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['capnhatdinhmuc']);
                }

                foreach ($data as $key => $value) {
                    if ($value['MA_CSHT']) {
                        $dulieudien = Quanlydien::find()
                            ->andFilterWhere(['=','THANG', (int)$params['UploadForm']['THANG']])
                            ->andFilterWhere(['=','NAM', $params['UploadForm']['NAM']])
                            ->andFilterWhere(['=', 'MA_CSHT', $value['MA_CSHT']])
                            ->one();
                        if ($dulieudien) {
                            $dulieudien->DINHMUC = $value['DINHMUC'];
                            $dulieudien->save(false);
                            $data[$key]['success'] = 'Đã cập nhật';
                        }
                    }
                }
                $log = new ActivitiesLog;
                $log->activity_type = 'dien-capnhatdinhmuc';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." cập nhật định mức tháng  ". $params['UploadForm']['THANG'] . '/' . $params['UploadForm']['NAM'];
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save(false);
                $data = array_merge([$keys], $data);
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->fromArray(
                    $data,
                    '',
                    'A1'
                );

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "Export_dinhmuc_".date('Ymd_His');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save("php://output");
                exit;
            }

            return $this->render('capnhatdinhmuc', [
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

    public function actionThongketramvuotdinhmuc()
    {
        if (Yii::$app->user->can('bctonghop-qldien')) {
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = $i;
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $params = Yii::$app->request->queryParams;
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            if (!$params) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'THANG' => date('m'),
                    'NAM' => date('Y'),
                    'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI
                ]);
            } else {
                $iddv = $params['ID_DONVI'] ? $params['ID_DONVI'] : $iddv;
            }
            $params['is_excel'] = $params['is_excel'] ?? null;
            $params['is_dinhmuc'] = $params['is_dinhmuc'] ?? null;
            $thang = $params['THANG'];
            $nam = $params['NAM'];
            $dsdai = ArrayHelper::map(Daivt::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DAI', 'ID_DAI');
            // $dstram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_TRAM', $iddv])->all(), 'ID_TRAM', 'TEN_TRAM');
            $dstram = Tramvt::find()->where(['in', 'ID_DAI', $dsdai])->all();
            $tongdien = [];
            $searchModel = new QuanlydienSearch();
            foreach ($dstram as $key => $value) {
                $tongdien[$value->MA_CSHT]['TEN_TRAM'] = $value->TEN_TRAM;
                $tongdien[$value->MA_CSHT]['DIADIEM'] = $value->MA_CSHT;
                $tongdien[$value->MA_CSHT]['THANG'] = 0;
                $tongdien[$value->MA_CSHT]['KW_TIEUTHU'] = 0;
                $tongdien[$value->MA_CSHT]['DINHMUC'] = 0;
                $tongdien[$value->MA_CSHT]['TONGTIEN'] = 0;
                $tongdien[$value->MA_CSHT]['KW_TIEUTHU_THANGTRUOC'] = 0;
                foreach ($searchModel->tonghopdinhmuctheotram($value->MA_CSHT, $nam, $thang) as  $v) {
                    $tongdien[$value->MA_CSHT]['KW_TIEUTHU'] = $v['KW_TIEUTHU'];
                    $tongdien[$value->MA_CSHT]['DINHMUC'] = $v['DINHMUC'];
                    $tongdien[$value->MA_CSHT]['TONGTIEN'] = $v['TONGTIEN'];
                }

                foreach ($searchModel->tonghopdinhmuctheotram($value->MA_CSHT, $nam, ($thang - 1)) as  $v) {
                    $tongdien[$value->MA_CSHT]['KW_TIEUTHU_THANGTRUOC'] = $v['KW_TIEUTHU'];
                }
                if (!$tongdien[$value->MA_CSHT]['KW_TIEUTHU'] && !$tongdien[$value->MA_CSHT]['KW_TIEUTHU_THANGTRUOC']) {
                    unset($tongdien[$value->MA_CSHT]);
                }

                if (isset($tongdien[$value->MA_CSHT]) && $params['is_dinhmuc'] && ($tongdien[$value->MA_CSHT]['KW_TIEUTHU'] <= $tongdien[$value->MA_CSHT]['DINHMUC'])) {
                    unset($tongdien[$value->MA_CSHT]);
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
                        'Điện tiêu thụ tháng ' . $params['THANG'] . '(TỔNG TIỀN)',
                        'Định mức tháng' . $params['THANG'],
                        'Điện tiêu thụ tháng ' . $params['THANG'] . '(KW)',
                        'Điện tiêu thụ tháng ' . ($params['THANG'] - 1) . '(KW)',
                    ],
                    '',
                    'A1'         
                );
                $key = 0;
                $x = 2;
                foreach ($tongdien as $value) {
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", ($key + 1))
                        ->setCellValue("B$x", $value['TEN_TRAM'])
                        ->setCellValue("C$x", $value['DIADIEM'])
                        ->setCellValue("D$x", formatnumber($value['TONGTIEN']))
                        ->setCellValue("E$x", formatnumber($value['DINHMUC']))
                        ->setCellValue("F$x", formatnumber($value['KW_TIEUTHU']))
                        ->setCellValue("G$x", formatnumber($value['KW_TIEUTHU_THANGTRUOC']));
                    $key ++;
                    $x ++;
                }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $file_name = "Export_".date('Ymd_His');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save("php://output");
        exit;
            }

            return $this->render('thongketramvuotdinhmuc', [
                    'tongdien' => $tongdien,
                    'dsdonvi' => $dsdonvi,
                    'params' => $params,
                    'months' => $months,
                    'years' => $years,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionCapnhatthanhtoandien()
    {
        if (Yii::$app->user->can('updatett-qldien')) {
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
            if (Yii::$app->request->get('AddSelection')) {
                $selected_array = Yii::$app->request->get('AddSelection');
                $sql  = 'UPDATE quanlydien SET IS_CHECKED = 1 WHERE ID IN ('  . implode(',', $selected_array) . ')';
                Yii::$app->db->createCommand($sql)->execute();

                Yii::$app->session->setFlash('success', "Cập nhật thanh toán thành công!");
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'TEN_DONVI');
            $searchModel = new QuanlydienSearch();
            $dataProvider = $searchModel->searchThongkedienchuathanhtoan(Yii::$app->request->queryParams);
            return $this->render('thongkesudungdienchuathanhtoan', [
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

    public function actionUpdatethanhtoan()
    {
        if (Yii::$app->user->can('updatett-qldien')) {
            if (Yii::$app->request->post('AddSelection')) {
                $selected_array = Yii::$app->request->post('AddSelection');
                $sql  = 'UPDATE quanlydien SET IS_CHECKED = 1 WHERE ID IN ('  . implode(',', $selected_array) . ')';
                Yii::$app->db->createCommand($sql)->execute();

                Yii::$app->session->setFlash('success', "Cập nhật thanh toán thành công!");
            }

            return $this->redirect(['capnhatthanhtoandien']);
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
            if ($params['ID_DONVI']) {
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
            $years = [
                date('Y') - 1 => date('Y') - 1,
                date('Y') => date('Y'),
            ];
            $params = Yii::$app->request->queryParams;
            if (!$params || !isset($params['NAM'])) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'NAM' => date('Y'),
                ]);
            }
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
                foreach ($searchModel->tonghoptheodonvi($key, $params['NAM']) as $v) {
                    $tongdien[$key][$v['THANG']] = $v['KW_TIEUTHU'];
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
                foreach ($searchModel->tonghoptientheodonvi($key, $params['NAM']) as $v) {
                    $tongtram[$key][$v['THANG']] = $v['TONGTIEN'];
                }
            }
            return $this->render('tonghoptheodonvi', [
                    'tongdien' => $tongdien,
                    'tongtram' => $tongtram,
                    'params' => $params,
                    'years' => $years,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionExporttonghoptheotram()
    {
        $data = [];
        $searchModel = new QuanlydienSearch();
        $data1 = $searchModel->tonghoptramphatsinhtheotram();
        foreach ($data1 as $value) {
            if (isset($data[$value['MA_CSHT']])) {
                $data[$value['MA_CSHT']][ 'KW sử dụng tháng '. $value['THANG']] = $value['KW_TIEUTHU'];
                $data[$value['MA_CSHT']][ 'Tổng tiền tháng '. $value['THANG']] = $value['TONGTIEN'];
            } else {
                $data[$value['MA_CSHT']] = [];
                $data[$value['MA_CSHT']] = $value;
                $data[$value['MA_CSHT']][ 'KW sử dụng tháng '. $value['THANG']] = $value['KW_TIEUTHU'];
                $data[$value['MA_CSHT']][ 'Tổng tiền tháng '. $value['THANG']] = $value['TONGTIEN'];
            }

            unset($data[$value['MA_CSHT']]['THANG']);
            unset($data[$value['MA_CSHT']]['KW_TIEUTHU']);
            unset($data[$value['MA_CSHT']]['TONGTIEN']);
        }
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->fromArray(array_keys($data['CSHT_HNM_00226']), '', 'A1');
        $spreadsheet->getActiveSheet()->fromArray($data, '', 'A2');

        $filename = 'Dữ liệ diện.xlsx'; //save our workbook as this file name
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
    public function actionExporttramchuamap()
    {
        $data = [];
        $searchModel = new QuanlydienSearch();
        $params = Yii::$app->request->queryParams;
        $params['THANG'] = $params['THANG'] ?? date('m');
        $params['NAM'] = $params['NAM'] ?? date('y');
        $data1 = $searchModel->tramchuamap($params);
            return $this->render('tramchuamap', [
                    'data1' => $data1,
                ]);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->fromArray($data1, '', 'A1');

        $filename = 'Dữ liệ diện lỗi.xlsx'; //save our workbook as this file name
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

    public function actionBaocaodientheomuc()
    {
        $data = [];
        $searchModel = new QuanlydienSearch();
        $data1 = $searchModel->baocaodientheomuc();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->fromArray([['Tên trung tâm', 'THÁNG','DƯỚI 500 KW', 'TỪ 500 ĐẾN 1000', 'TỪ 1000 - 1500', 'TỪ 1500 - 2000', 'TỪ 2000 - 2500', 'TỪ 2500 - 3000', 'TỪ 3000 - 3500', 'TỪ 3500 - 4000', 'TỪ 4000 - 4500', 'TỪ 4500 - 5000', 'LỚN HƠN 5000']], '', 'A1');
        $spreadsheet->getActiveSheet()->fromArray($data1, '', 'A2');
        $filename = 'Dữ liệu theo mức.xlsx'; //save our workbook as this file name
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
    public function actionBaocaotonghoptheotram()
    {
        if (Yii::$app->user->can('bctonghop-qldien')) {
            $years = [
                date('Y') - 1 => date('Y') - 1,
                date('Y') => date('Y'),
            ];
            $params = Yii::$app->request->queryParams;
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            if (!$params) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'LOAIBC' => 'KW_TIEUTHU',
                    'NAM' => date('Y'),
                    'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI
                ]);
            } else {
                $iddv = $params['ID_DONVI'] ? $params['ID_DONVI'] : $iddv;
            }
            $params['is_excel'] = $params['is_excel'] ?? null;
            $loaibc = $params['LOAIBC'];
            $searchModelTramvt = new TramvtSearch();
            $dstram = $searchModelTramvt->searchDSTramvt($iddv);
            $tongdien = [];
            $searchModel = new QuanlydienSearch();
            foreach ($dstram as $key => $value) {
                $tongdien[$value['MA_CSHT']] = [
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
                $tongdien[$value['MA_CSHT']]['TEN_DONVI'] = $value['TEN_DONVI'];
                $tongdien[$value['MA_CSHT']]['TEN_TRAM'] = $value['TEN_TRAM'];
                $tongdien[$value['MA_CSHT']]['DIADIEM'] = $value['MA_CSHT'];
                foreach ($searchModel->tonghoptheotram($value['MA_CSHT'], $params['NAM'], $loaibc) as $v) {
                    $tongdien[$value['MA_CSHT']][$v['THANG']] = $v['TONG_TT'];
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
                foreach ($tongdien as $value) {
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
                $file_name = "Export_".date('Ymd_His');

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save("php://output");
                exit;
            }

            return $this->render('tonghoptheotram', [
                    'tongdien' => $tongdien,
                    'dmloaibc' => ['TONGTIEN' => 'Báo cáo theo tổng tiền', 'KW_TIEUTHU' => 'Báo cáo theo điện tiêu thụ'],
                    'dsdonvi' => $dsdonvi,
                    'params' => $params,
                    'years' => $years,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionBaocaocungky()
    {
        if (Yii::$app->user->can('bctonghop-qldien')) {
            $years = [
                date('Y') - 2 => date('Y') - 2,
                date('Y') - 1 => date('Y') - 1,
                date('Y') => date('Y'),
            ];
            $params = Yii::$app->request->queryParams;
            if (!$params || !isset($params['NAM'])) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'NAM' => date('Y'),
                ]);
            }
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'MA_DONVIKT', 'TEN_DONVI');
            $tongdien = [];
            $tongdienold = [];
            $searchModel = new QuanlydienSearch();
            foreach ($dsdonvi as $key => $value) {
                $tongdien[$key]['DATANOW'] = [
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
                $tongdien[$key]['DATAOLD'] = [
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
                $tongdien[$key]['DATAOLDOLD'] = [
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
                $tongdien[$key]['borderWidth'] = 1;
                foreach ($searchModel->tonghoptheodonvi($key, $params['NAM']) as $v) {
                    $tongdien[$key]['DATANOW'][$v['THANG']] = $v['KW_TIEUTHU'];
                }
                foreach ($searchModel->tonghoptheodonvi($key, $params['NAM'] - 1) as $v) {
                    $tongdien[$key]['DATAOLD'][$v['THANG']] = $v['KW_TIEUTHU'];
                }
                foreach ($searchModel->tonghoptheodonvi($key, $params['NAM'] - 2) as $v) {
                    $tongdien[$key]['DATAOLDOLD'][$v['THANG']] = $v['KW_TIEUTHU'];
                }
            }
            return $this->render('baocaocungky', [
                    'tongdien' => $tongdien,
                    'params' => $params,
                    'years' => $years,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionGetdulieudien()
    {
        $datakw = '{"Nam":2019,"MaKhachHang":"PA24HN0008868","htmlTableDuLieuChiTietChiSo":null,"lstData":[[{"DienTieuThu":74040,"SoTien":0,"Thang":1,"Nam":0},{"DienTieuThu":77160,"SoTien":0,"Thang":2,"Nam":0},{"DienTieuThu":69480,"SoTien":0,"Thang":3,"Nam":0},{"DienTieuThu":80400,"SoTien":0,"Thang":4,"Nam":0},{"DienTieuThu":84960,"SoTien":0,"Thang":5,"Nam":0},{"DienTieuThu":93240,"SoTien":0,"Thang":6,"Nam":0},{"DienTieuThu":90360,"SoTien":0,"Thang":7,"Nam":0},{"DienTieuThu":89280,"SoTien":0,"Thang":8,"Nam":0},{"DienTieuThu":81000,"SoTien":0,"Thang":9,"Nam":0},{"DienTieuThu":81856,"SoTien":0,"Thang":10,"Nam":0},{"DienTieuThu":75944,"SoTien":0,"Thang":11,"Nam":0},{"DienTieuThu":72520,"SoTien":0,"Thang":12,"Nam":0}],[{"DienTieuThu":68341,"SoTien":0,"Thang":1,"Nam":0},{"DienTieuThu":67320,"SoTien":0,"Thang":2,"Nam":0},{"DienTieuThu":72720,"SoTien":0,"Thang":3,"Nam":0},{"DienTieuThu":74280,"SoTien":0,"Thang":4,"Nam":0},{"DienTieuThu":88680,"SoTien":0,"Thang":5,"Nam":0},{"DienTieuThu":93120,"SoTien":0,"Thang":6,"Nam":0},{"DienTieuThu":89040,"SoTien":0,"Thang":7,"Nam":0},{"DienTieuThu":83160,"SoTien":0,"Thang":8,"Nam":0},{"DienTieuThu":86400,"SoTien":0,"Thang":9,"Nam":0},{"DienTieuThu":78240,"SoTien":0,"Thang":10,"Nam":0},{"DienTieuThu":78720,"SoTien":0,"Thang":11,"Nam":0},{"DienTieuThu":70440,"SoTien":0,"Thang":12,"Nam":0}]]}';
        $datatien = '{"Nam":2019,"MaKhachHang":"PA24HN0008868","htmlTableDuLieuChiTietChiSo":null,"lstData":[[{"DienTieuThu":0,"SoTien":136045536,"Thang":1,"Nam":0},{"DienTieuThu":0,"SoTien":140990784,"Thang":2,"Nam":0},{"DienTieuThu":0,"SoTien":129321328,"Thang":3,"Nam":0},{"DienTieuThu":0,"SoTien":159018816,"Thang":4,"Nam":0},{"DienTieuThu":0,"SoTien":168708016,"Thang":5,"Nam":0},{"DienTieuThu":0,"SoTien":186452240,"Thang":6,"Nam":0},{"DienTieuThu":0,"SoTien":180949424,"Thang":7,"Nam":0},{"DienTieuThu":0,"SoTien":178106816,"Thang":8,"Nam":0},{"DienTieuThu":0,"SoTien":1.614059E+08,"Thang":9,"Nam":0},{"DienTieuThu":0,"SoTien":1.628786E+08,"Thang":10,"Nam":0},{"DienTieuThu":0,"SoTien":149684352,"Thang":11,"Nam":0},{"DienTieuThu":0,"SoTien":1.438355E+08,"Thang":12,"Nam":0}],[{"DienTieuThu":0,"SoTien":125844192,"Thang":1,"Nam":0},{"DienTieuThu":0,"SoTien":123356640,"Thang":2,"Nam":0},{"DienTieuThu":0,"SoTien":133116192,"Thang":3,"Nam":0},{"DienTieuThu":0,"SoTien":136535520,"Thang":4,"Nam":0},{"DienTieuThu":0,"SoTien":164588688,"Thang":5,"Nam":0},{"DienTieuThu":0,"SoTien":171932112,"Thang":6,"Nam":0},{"DienTieuThu":0,"SoTien":164890976,"Thang":7,"Nam":0},{"DienTieuThu":0,"SoTien":154580976,"Thang":8,"Nam":0},{"DienTieuThu":0,"SoTien":158698048,"Thang":9,"Nam":0},{"DienTieuThu":0,"SoTien":144765728,"Thang":10,"Nam":0},{"DienTieuThu":0,"SoTien":144274144,"Thang":11,"Nam":0},{"DienTieuThu":0,"SoTien":1.296438E+08,"Thang":12,"Nam":0}]]}';
        
        $datakw = json_decode($datakw, true);
        $datatien = json_decode($datatien, true);
        $makh = $datakw['MaKhachHang'];
        $lstDatakw = $datakw['lstData'];
        $lstDatatien = $datatien['lstData'];
        $nam = $datakw['Nam'];
        $namtien = $datatien['Nam'];
        echo '<pre>';
        $data = [];
        $i = 0;
        foreach ($lstDatakw[0] as $key => $value) {
            $data[$makh][$i][$value['Thang']]['MA_DIENLUC'] = $makh;
            $data[$makh][$i][$value['Thang']]['NAM'] = $nam;
            $data[$makh][$i][$value['Thang']]['THANG'] = $value['Thang'];
            $data[$makh][$i][$value['Thang']]['KW_TIEUTHU'] = $value['DienTieuThu'];
            $data[$makh][$i][$value['Thang']]['ID_NHANVIEN'] = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;;
            $data[$makh][$i][$value['Thang']]['IS_CHECKED'] = NULL;
            $data[$makh][$i][$value['Thang']]['THOIGIANCAPNHAT'] = date("Y-m-d H:i:s");
            $data[$makh][$i][$value['Thang']]['NH_DIENLUC'] = 'VNPT HA NAM';
            $data[$makh][$i][$value['Thang']]['TK_DIENLUC'] = '123456';
        }
        foreach ($lstDatatien[0] as $key => $value) {
            $data[$makh][$i][$value['Thang']]['TIENDIEN'] = (int)$value['SoTien'];
            $data[$makh][$i][$value['Thang']]['TONGTIEN'] = (int)$value['SoTien'];
            $data[$makh][$i][$value['Thang']]['TIENTHUE'] = (int)$value['SoTien'] / 10;
        }
        foreach ($lstDatakw[1] as $key => $value) {
            $data[$makh][$nam - 1][$value['Thang']]['MA_DIENLUC'] = $makh;
            $data[$makh][$nam - 1][$value['Thang']]['NAM'] = $nam - 1;
            $data[$makh][$nam - 1][$value['Thang']]['THANG'] = $value['Thang'];
            $data[$makh][$nam - 1][$value['Thang']]['KW_TIEUTHU'] = $value['DienTieuThu'];
            $data[$makh][$nam - 1][$value['Thang']]['ID_NHANVIEN'] = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;;
            $data[$makh][$nam - 1][$value['Thang']]['IS_CHECKED'] = NULL;
            $data[$makh][$nam - 1][$value['Thang']]['THOIGIANCAPNHAT'] = date("Y-m-d H:i:s");
        }
        foreach ($lstDatatien[1] as $key => $value) {
            $data[$makh][$nam - 1][$value['Thang']]['TIENDIEN'] = (int)$value['SoTien'];
            $data[$makh][$nam - 1][$value['Thang']]['TONGTIEN'] = (int)$value['SoTien'];
            $data[$makh][$nam - 1][$value['Thang']]['TIENTHUE'] = (int)$value['SoTien'] / 10;
        }
        die(var_dump($data));
    }
}
                        // $model1 = new Quanlydien();
                        // $model1->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        // $model1->IS_CHECKED = NULL;
                        // $model1->MA_DIENLUC = $value['MA_DIENLUC'];
                        // $model1->TEN_DIENLUC = $value['TEN_DIENLUC'];
                        // $model1->TK_DIENLUC = $value['TK_DIENLUC'];
                        // $model1->NH_DIENLUC = $value['NH_DIENLUC'];
                        // $model1->MA_CSHT = $value['MA_CSHT'];
                        // $model1->MA_DONVIKT = $params['UploadForm']['MA_DONVIKT'];
                        // $model1->TIENDIEN = (int)$value['TIENDIEN'];
                        // $model1->TIENTHUE = (int)$value['TIENTHUE'];
                        // $model1->TONGTIEN = (int)$value['TONGTIEN'];
                        // $model1->KW_TIEUTHU = (int)$value['KW_TIEUTHU'];
                        // $model1->THOIGIANCAPNHAT = date("Y-m-d H:i:s");
                        // $model1->NAM = $params['UploadForm']['NAM'];
                        // $model1->THANG = $params['UploadForm']['THANG'];
                        // $model1->save(false);