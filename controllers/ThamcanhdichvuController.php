<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Donvi;
use app\models\Khachhangthamcanh;
use app\models\LichsutiepxucthamcanhSearch;
use app\models\Lichsutiepxucthamcanh;
use app\models\Dichvu;
use app\models\KhachhangthamcanhSearch;
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
class ThamcanhdichvuController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new KhachhangthamcanhSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        $dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
        $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DONVI', [668,9]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dsDichvu' => $dsDichvu,
            'dsNhanvien' => $dsNhanvien,
        ]);
    }

        public function actionImport()
    {
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [9,668]])->all(), 'ID_DONVI', 'TEN_DONVI');
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DONVI', [668,9]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                // $data = $data[0];
                // die(var_dump($data));
                $keys = array_keys($data[0]);
                $arrkeyCheck = ['TEN_KH', 'MST', 'DIACHI'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['import']);
                }
                foreach ($data as $key => $value) {
                    if ($value['MST']) {
                        $model1 = Khachhangthamcanh::find()->where(['TEN_KH' => $value['TEN_KH']])->andwhere(['DIACHI' => $value['DIACHI']])->one();
                        if(!$model1) {
                            $model1 = new Khachhangthamcanh();
                        }
                        // $nhanvien = Nhanvien::find()->where(['TEN_NHANVIEN' => $value['TEN_NV_KD']])->one();
                        $model1->nhanvien_id = $params['UploadForm']['nhanvien_id'];
                        $model1->TEN_NV_KD = '';
                        $model1->TEN_KH = $value['TEN_KH'];
                        $model1->MST = $value['MST'];
                        $model1->DIACHI = $value['DIACHI'] ? $value['DIACHI'] : ' ';
                        $model1->LIENHE = '';
                        $model1->EMAIL = '';
                        $model1->DICHVU_ID = '';
                        $model1->NGAY_HH = '';
                        $model1->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            }

            return $this->render('import', [
                'model' => $model,
                'dsdonvi' => $dsdonvi,
                'dsNhanvien' => $dsNhanvien,
            ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDashboard()
    {
        $dsketquagiahanca = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN,SUM(CASE WHEN MONTH(b.NGAY_HH) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND b.DICHVU_ID = 10  group by c.TEN_NHANVIEN')->queryAll();
            $dsketquagiahanivan = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN,SUM(CASE WHEN MONTH(b.NGAY_HH) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND b.DICHVU_ID = 15  group by c.TEN_NHANVIEN')->queryAll();

            $searchModel = new KhachhangthamcanhSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->searchtrangchu($params);
            $dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DAI', [25280]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            return $this->render('dashboard', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dsketquagiahanca' => $dsketquagiahanca,
                'dsketquagiahanivan' => $dsketquagiahanivan,
                'dsDichvu' => $dsDichvu,
                'dsNhanvien' => $dsNhanvien,
            ]);
    }

    protected function findModel($id)
    {
        if (($model = Khachhangthamcanh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dsNhanvien = ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('success', "cập nhật khách hàng thành công!");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dsNhanvien' => $dsNhanvien,
            ]);
        }
    }

    public function actionTiepxuckhachhang($id)
    {
        $khachhang = $this->findModel($id);
        $model = Lichsutiepxucthamcanh::find()->where([
            'nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
            'khachhanggh_id' => $id,
            'date(ngay_tiepxuc)' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d'),
        ])->one();
        if (!$model) {
            $model = new Lichsutiepxucthamcanh();
            $model->khachhanggh_id = $id;
            $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
        }

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->ds_dichvu = implode(',', $params['Lichsutiepxucthamcanh']['ds_dichvu']);
            $model->ketqua = implode(',', $params['Lichsutiepxucthamcanh']['ketqua']);
            $model->ghichu = $params['Lichsutiepxucthamcanh']['ghichu'];
            $model->save(false);
            $khachhang->ngay_lh = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $khachhang->ht_lh = $model->ht_tc;
            $khachhang->ketqua = $model->ketqua;
            $khachhang->ghichu = $model->ghichu;
            $khachhang->save(false);
            Yii::$app->session->setFlash('success', "Đã thực thiện tiếp xúc khách hàng thành công!");
            return $this->redirect(['view', 'id' => $khachhang->id]);
        } else {
            $dsDichvu = ArrayHelper::map(Dichvu::find()->orderBy('stt')->all(), 'id', 'ten_dv');
            return $this->render('tiepxuckhachhang', [
                'model' => $model,
                'khachhang' => $khachhang,
                'dsDichvu' => $dsDichvu,
            ]);
        }
    }

    public function actionLichsutiepxuc()
    {
            $searchModel = new LichsutiepxucthamcanhSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->search($params);
            return $this->render('lichsutiepxuc', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionExcellichsutiepxucthamcanh()
    {
        $result = Yii::$app->db->createCommand('SELECT a.MST, a.TEN_KH, a.LIENHE, a.EMAIL, a.ht_lh, a.ketqua, a.ghichu, a.ngay_lh,b.TEN_NHANVIEN FROM khachhangthamcanh a, nhanvien b WHERE a.nhanvien_id = b.ID_NHANVIEN')->queryAll();
        foreach ($result as $key => $value) {
            $result[$key]['ketqua'] = isset(ketquagiahan()[$value['ketqua']]) ? ketquagiahan()[$value['ketqua']] : null;
            $result[$key]['ht_lh'] = isset(hinhthuctx()[$value['ht_lh']]) ? hinhthuctx()[$value['ht_lh']] : null;
        }
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->fromArray(
            [
                'MÃ SỐ THUẾ',
                'TÊN KHÁCH HÀNG',
                'SỐ LIÊN HỆ',
                'EMAIL',
                'HÌNH THỨC LIÊN HỆ',
                'KẾT QUẢ',
                'GHI CHÚ',
                'NGÀY LIÊN HỆ',
                'NHÂN VIÊN HỖ TRỢ',
            ],
            '',
            'A1'
        );
        $key = 0;
        $x = 2;
        $spreadsheet->getActiveSheet()->fromArray($result,'','A2');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_name = "Gia hạn dịch vụ ".date('Ymd_His');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
        exit;
    }
}