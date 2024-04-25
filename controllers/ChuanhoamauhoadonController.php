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

            if ($params['Chuanhoamauhoadon']['ketqua'] == 4 && !$model->anhtruocchuanhoa) {
                $model->ketqua = 0;
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
        $baocaotonghop = Yii::$app->db->createCommand('SELECT b.TEN_NHANVIEN
,COUNT(1) SO_LUONG
,ROUND(COUNT(1) / 20) SO_LUONG_NGAY
, SUM(case when a.ketqua = 0 then 1 ELSE 0 END) CHUA_TH
, SUM(case when a.ketqua > 0 AND DATE(a.ngay_yc) = CURDATE() then 1 ELSE 0 END) SO_LUONG_TRONG_NGAY
, SUM(case when a.ketqua = 1 then 1 ELSE 0 END) DANG_YC_SUA
, SUM(case when a.ketqua = 2 then 1 ELSE 0 END) CHUA_DA_SUA
, SUM(case when a.ketqua = 3 then 1 ELSE 0 END) HOANTHANH_SUA
, SUM(case when a.ketqua = 4 then 1 ELSE 0 END) KHONG_SUA
,SUM(case when a.ketqua = 4 OR a.ketqua = 3 then 1 ELSE 0 END) TONG_HOANTHANH
,round(SUM(case when a.ketqua = 4 OR a.ketqua = 3 then 1 ELSE 0 END) * 100 / COUNT(1)) TI_LE
FROM chuanhoahddt a, nhanvien b WHERE a.NVQL_ID = b.ID_NHANVIEN GROUP BY b.TEN_NHANVIEN')->queryAll();
        return $this->render('dashboard', [
            'baocaotonghop' => $baocaotonghop,
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
