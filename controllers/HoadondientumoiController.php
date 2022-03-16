<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Donvi;
use app\models\Hddtmoi;
use app\models\Tiepxuchoadon;
use app\models\TiepxuchoadonSearch;
use app\models\HddtmoiSearch;
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
class HoadondientumoiController extends Controller
{
    public function actionIndex()
    {
            $searchModel = new HddtmoiSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->search($params);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

        public function actionImport()
    {
            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DONVI', [668]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                $keys = array_keys($data[0]);
                $arrkeyCheck = ['TEN_KH', 'MST', 'DIACHI', 'LIENHE', 'EMAIL'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['import']);
                }
                foreach ($data as $key => $value) {
                    if ($value['MST']) {
                        $model1 = new Hddtmoi();
                        $model1->nhanvien_id = $params['UploadForm']['nhanvien_id'];
                        $model1->donvi_id = $params['UploadForm']['donvi_id'];
                        $model1->TEN_KH = $value['TEN_KH'];
                        $model1->MST = $value['MST'];
                        $model1->DIACHI = $value['DIACHI'];
                        $model1->LIENHE = $value['LIENHE'];
                        $model1->EMAIL = $value['EMAIL'];
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
        if (($model = Hddtmoi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('success', "cập nhật khách hàng thành công!");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dsdonvi' => $dsdonvi,
            ]);
        }
    }

    public function actionTiepxuckhachhang($id)
    {
        $khachhang = $this->findModel($id);
        $model = Tiepxuchoadon::find()->where([
            'nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
            'hddtmoi_id' => $id,
            'date(ngay_tiepxuc)' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d'),
        ])->one();
        if (!$model) {
            $model = new Tiepxuchoadon();
            $model->hddtmoi_id = $id;
            $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
        }

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->ghichu = $params['Tiepxuchoadon']['ghichu'];
            $model->save(false);
            $khachhang->ngay_lh = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
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
            $searchModel = new TiepxuchoadonSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->search($params);
            return $this->render('lichsutiepxuc', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    } 
}