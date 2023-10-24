<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Donvi;
use app\models\Nguyennhan;
use app\models\Chuanhoamauhoadon;
use app\models\Dichvu;
use app\models\Anhchuanhoa;
use app\models\ChuanhoamauhoadonSearch;
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
class ChuanhoamauhoadonController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ChuanhoamauhoadonSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndextheoketqua()
    {
        $searchModel = new ChuanhoamauhoadonSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchketqua($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        if (($model = Chuanhoamauhoadon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            if (isset($params['Chuanhoamauhoadon']['ghichu'])) {
                $model->ghichu = $params['Chuanhoamauhoadon']['ghichu'];
            }
            if (isset($params['Chuanhoamauhoadon']['ghichu_xl'])) {
                $model->ghichu_xl = $params['Chuanhoamauhoadon']['ghichu_xl'];
            }
            if ($params['Chuanhoamauhoadon']['ketqua'] == 1 && !$model->anhtruocchuanhoa) {
                $model->ketqua = 0;
                Yii::$app->session->setFlash('error', "Cần cập nhật ảnh hiện trạng trước khi yêu cầu sửa mẫu!");
                return $this->redirect(['update', 'id' => $id]);
            }

            if ($params['Chuanhoamauhoadon']['ketqua'] == 2 && !$model->anhsauchuanhoa) {
                $model->ketqua = 1;
                Yii::$app->session->setFlash('error', "Cần cập nhật ảnh sau chỉnh sửa trước khi đóng phiếu!");
                return $this->redirect(['update', 'id' => $id]);
            }
            $model->ketqua = $params['Chuanhoamauhoadon']['ketqua'];
            if ($model->ketqua == 1) {
                $model->ngay_yc = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            }
            if ($model->ketqua == 2) {
                $model->ngay_sua = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            }
            if ($model->ketqua == 3) {
                $model->ngay_dong = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            }
            if ($model->ketqua == 4) {
                $model->ngay_yc = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', "cập nhật khách hàng thành công!");
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDashboard()
    {
        $params = Yii::$app->request->queryParams;
        $thang = isset($params['thang']) ? $params['thang']  : date('m');
        $dsketquagiahanca = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM Chuanhoamauhoadon b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID = 116  group by c.TEN_NHANVIEN')->queryAll();
        $dsketquagiahanivan = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM Chuanhoamauhoadon b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID in (132)  group by c.TEN_NHANVIEN')->queryAll();
        $dsketquagiahanhddt = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM Chuanhoamauhoadon b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID in (122)  group by c.TEN_NHANVIEN')->queryAll();
        $dsketquagiahandvkhac = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, COUNT(1) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM Chuanhoamauhoadon b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND MONTH(b.NGAY_HH) = ' . $thang . ' AND b.DICHVU_ID not in (132,116,122)  group by c.TEN_NHANVIEN')->queryAll();
        $searchModel = new ChuanhoamauhoadonSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchtrangchu($params);
        $dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
        $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DAI', [25280]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
        return $this->render('dashboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dsketquagiahanca' => $dsketquagiahanca,
            'dsketquagiahanivan' => $dsketquagiahanivan,
            'dsketquagiahanhddt' => $dsketquagiahanhddt,
            'dsketquagiahandvkhac' => $dsketquagiahandvkhac,
            'dsDichvu' => $dsDichvu,
            'dsNhanvien' => $dsNhanvien,
        ]);
    }

    public function actionUploadbase64v2()
    {
        $inputs = Yii::$app->request->bodyParams;
        $id = Yii::$app->request->post('chuanhoa_id');
        $datetime = Yii::$app->request->post('datetime');
        if ($inputs['IMAGEBASE64']) {
            $model = new Anhchuanhoa();
            $model->chuanhoa_id = $id;
            $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->type = $inputs['type'];
            $img_data = str_replace('data:image/jpeg;base64,',  '', $inputs['IMAGEBASE64']);
            $filename = Yii::$app->user->identity->nhanvien->ID_NHANVIEN . $id . time() . '.jpeg';
            $img_data = base64_decode($img_data);
            file_put_contents(\Yii::getAlias('@webroot') . '/dist/anhchuanhoahddt/' .  $filename , $img_data);
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
