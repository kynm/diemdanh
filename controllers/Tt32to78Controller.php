<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Donvi;
use app\models\Tt32to78;
use app\models\Hotrott32to78;
use app\models\Hotrott32to78Search;
use app\models\Tt32to78Search;
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
class Tt32to78Controller extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->can('cucthuetinh')) {
            return $this->redirect(['baocaothue']);
        }
        $searchModel = new Tt32to78Search();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                        $model1 = new Tt32to78();
                        $model1->nhanvien_id = $value['nhanvien_id'];
                        $model1->donvi_id = 1;
                        $model1->TEN_KH = $value['TEN_KH'];
                        $model1->SDT = $value['SDT'];
                        // $model1->SLDANGKY = $value['SLDANGKY'];
                        // $model1->SLTHONGBAO = $value['SLTHONGBAO'];
                        // $model1->SLDAPHATHANH = $value['SLDAPHATHANH'];
                        $model1->MST = $value['MST'];
                        $model1->DIACHI = $value['DIACHI'];
                        $model1->LIENHE = $value['LIENHE'];
                        $model1->EMAIL = $value['EMAIL'];
                        $model1->GUIDK01 = '0';
                        $model1->TRANGTHAINANGCAP = '0';
                        $model1->TEN_NV_KD = $value['TEN_NV_KD'];
                        $model1->LOAIHETHONG = $value['LOAIHETHONG'];
                        $model1->NHANVIENHOTRO = 'xxx';
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
        if (($model = Tt32to78::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       // $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('success', "cập nhật khách hàng thành công!");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                // 'dsdonvi' => $dsdonvi,
            ]);
        }
    }

    public function actionTiepxuckhachhang($id)
    {
        $khachhang = $this->findModel($id);
        $model = Hotrott32to78::find()->where([
            'nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
            'tt32to78_id' => $id,
            'date(ngay_tiepxuc)' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d'),
        ])->one();
        if (!$model) {
            $model = new Hotrott32to78();
            $model->tt32to78_id = $id;
            $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
        }

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->ghichu = $params['Hotrott32to78']['ghichu'];
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
            $searchModel = new Hotrott32to78Search();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->search($params);
            return $this->render('lichsutiepxuc', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionExcellichsutiepxuc()
    {
        $result = Yii::$app->db->createCommand('SELECT a.MST, a.TEN_KH, a.LIENHE, a.EMAIL, a.ht_lh, a.ketqua, a.ghichu, a.ngay_lh,b.TEN_NHANVIEN FROM khchuyendoi32to78 a, nhanvien b WHERE a.nhanvien_id = b.ID_NHANVIEN')->queryAll();
        foreach ($result as $key => $value) {
            $result[$key]['ketqua'] = isset(ketqua32to78()[$value['ketqua']]) ? ketqua32to78()[$value['ketqua']] : null;
            $result[$key]['ht_lh'] = isset(ketqua32to78()[$value['ht_lh']]) ? ketqua32to78()[$value['ht_lh']] : null;
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
        $file_name = "Chuyển đổi tt78 ".date('Ymd_His');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
        exit;
    }
}