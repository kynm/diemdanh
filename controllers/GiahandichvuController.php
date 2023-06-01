<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Donvi;
use app\models\Khachhanggiahan;
use app\models\LichsutiepxucSearch;
use app\models\Lichsutiepxuc;
use app\models\Dichvu;
use app\models\Anhgiahan;
use app\models\KhachhanggiahanSearch;
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
class GiahandichvuController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new KhachhanggiahanSearch();
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
                $arrkeyCheck = ['TEN_KH', 'MST', 'DIACHI', 'LIENHE', 'EMAIL'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['import']);
                }
                foreach ($data as $key => $value) {
                    if ($value['MST']) {
                        $model1 = Khachhanggiahan::find()->where(['MST' => $value['MST']])->andWhere(['DICHVU_ID' => $value['DICHVU_ID']])->one();
                        if(!$model1) {
                            $model1 = new Khachhanggiahan();
                        }
                        $nhanvien = Nhanvien::find()->where(['TEN_NHANVIEN' => $value['TEN_NV_KD']])->one();
                        $model1->nhanvien_id = $nhanvien ? $nhanvien->ID_NHANVIEN : 0;
                        $model1->TEN_NV_KD = $value['TEN_NV_KD'];
                        $model1->TEN_KH = $value['TEN_KH'];
                        $model1->MST = $value['MST'];
                        $model1->DIACHI = $value['DIACHI'];
                        $model1->LIENHE = $value['LIENHE'];
                        $model1->EMAIL = $value['EMAIL'];
                        $model1->DICHVU_ID = $value['DICHVU_ID'];
                        $model1->NGAY_HH = $value['NGAY_HH'];
                        $model1->THUEBAO_ID = $value['THUEBAO_ID'];
                        $model1->MA_TB = $value['MA_TB'];
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

    protected function findModel($id)
    {
        if (($model = Khachhanggiahan::findOne($id)) !== null) {
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
        $model = Lichsutiepxuc::find()->where([
            'nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
            'khachhanggh_id' => $id,
            'date(ngay_tiepxuc)' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d'),
        ])->one();
        if (!$model) {
            $model = new Lichsutiepxuc();
            $model->khachhanggh_id = $id;
            $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
        }

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->ghichu = $params['Lichsutiepxuc']['ghichu'];
            $model->save(false);
            $khachhang->ngay_lh = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $khachhang->ht_lh = $model->ht_tc;
            $khachhang->ketqua = $model->ketqua;
            $khachhang->ghichu = $model->ghichu;
            $khachhang->save(false);
            Yii::$app->session->setFlash('success', "Đã thực thiện tiếp xúc khách hàng thành công!");
            return $this->redirect(['view', 'id' => $khachhang->id]);
        } else {
            return $this->render('tiepxuckhachhang', [
                'model' => $model,
                'khachhang' => $khachhang,
            ]);
        }
    }

    public function actionLichsutiepxuc()
    {
            $searchModel = new LichsutiepxucSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->search($params);
            return $this->render('lichsutiepxuc', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionExcellichsutiepxuc()
    {
        $result = Yii::$app->db->createCommand('SELECT a.MST, a.TEN_KH, a.LIENHE, a.EMAIL, a.ht_lh, a.ketqua, a.ghichu, a.ngay_lh,b.TEN_NHANVIEN FROM khachhanggiahan a, nhanvien b WHERE a.nhanvien_id = b.ID_NHANVIEN')->queryAll();
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

    public function actionDashboard()
    {
        $thang = 6;
        $dsketquagiahanca = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID = 116  group by c.TEN_NHANVIEN')->queryAll();
        $dsketquagiahanivan = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID in (132)  group by c.TEN_NHANVIEN')->queryAll();
        $dsketquagiahandvkhac = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID not in (132,116)  group by c.TEN_NHANVIEN')->queryAll();
        $searchModel = new KhachhanggiahanSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchtrangchu($params);
        $dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
        $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DAI', [25280]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
        return $this->render('dashboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dsketquagiahanca' => $dsketquagiahanca,
            'dsketquagiahanivan' => $dsketquagiahanivan,
            'dsketquagiahandvkhac' => $dsketquagiahandvkhac,
            'dsDichvu' => $dsDichvu,
            'dsNhanvien' => $dsNhanvien,
        ]);
    }

    public function actionUploadbase64v2()
    {
        $inputs = Yii::$app->request->bodyParams;
        $id = Yii::$app->request->post('giahan_id');
        $phieu = $this->findModel($id);
        if ($inputs['IMAGEBASE64']) {
            $model = new Anhgiahan();
            $model->giahan_id = $id;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $img_data = str_replace('data:image/jpeg;base64,',  '', $inputs['IMAGEBASE64']);
            $filename = Yii::$app->user->identity->nhanvien->ID_NHANVIEN . $id . time() . '.jpeg';
            $img_data = base64_decode($img_data);
            file_put_contents(\Yii::getAlias('@webroot') . '/dist/anhgiahan/' .  $filename , $img_data);
            $model->image_url = $filename;
            if ($model->save(false)) {
                return json_encode(["message" => "True","error" => 0, 'id' => $model->id, 'image_url' => $model->urlimage], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(["message" => "False!","error" => 1], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            Yii::$app->api->sendFailedResponse('Failed!');
        }
    }
}
