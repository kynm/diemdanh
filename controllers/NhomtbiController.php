<?php

namespace app\controllers;

use Yii;
use DateTime;
use yii\data\ActiveDataProvider;
use app\models\ThietbiSearch;
use app\models\ActivitiesLog;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Dotbaoduong;
use app\models\Nhanvien;
use app\models\Thietbitram;
use app\models\LogKiemtranhatram;
use app\models\Noidungcongviec;
use app\models\Tramvt;
use app\models\NhomtbiSearch;
use app\models\Noidungbaotrinhomtbi;
use app\models\Noidungbaotri;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * NhomtbiController implements the CRUD actions for Nhomtbi model.
 */
class NhomtbiController extends Controller
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

    /**
     * Lists all Nhomtbi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NhomtbiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nhomtbi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $devicesSearchModel = new ThietbiSearch();
        $devicesProvider = $devicesSearchModel->searchNhom(Yii::$app->request->queryParams);
        // $allDatas = Yii::$app->db->createCommand('SELECT * FROM `table 34`')->queryAll();
        // foreach ($allDatas as $key => $data) {
        //     $thietbi = Thietbi::findOne(['TEN_THIETBI' => $data['chungloai']]);
        //     $tramvt = Tramvt::findOne(['TEN_TRAM' => $data['ten_tram']]);
        //     // if (!$tramvt || !$thietbi) {
        //     if (!$tramvt) {
        //         // var_dump($data);
        //     } else {
        //         $thietbitram = new Thietbitram();
        //         $thietbitram->ID_LOAITB = $thietbi->ID_THIETBI;
        //         $thietbitram->ID_TRAM = $tramvt->ID_TRAM;
        //         $thietbitram->TEN_MA = $thietbi->TEN_THIETBI ?? 'VNPT NO NAME';
        //         $thietbitram->NGAYSX = date('Y-m-d');
        //         $thietbitram->NGAYSD = date('Y-m-d');
        //         $thietbitram->SERIAL_MAC = $thietbi->MA_THIETBI . '-' . $tramvt->MA_TRAM;
        //         $thietbitram->THAMSOTHIETBI = json_encode(
        //         [
        //             'DINH_MUC' => $data['tieuhao'],
        //             'LOAINHIENLIEU' => $data['nhienlieu'] == 'Diesel' ? 1 : 2,
        //         ]);
        //         // var_dump($thietbitram);
        //     }

        //     // $thietbi->MA_THIETBI = str_replace(' ', '', $data['chungloai']);
        //     // $thietbi->TEN_THIETBI = $data['chungloai'];
        //     // $thietbi->ID_NHOM = 1;
        //     // $thietbi->HANGSX = 'VNPT';
        //     // $thietbi->THONGSOKT = $data['nhienlieu'];
        // }
        // die('ok');
        $query = Noidungbaotrinhomtbi::find()->where(['ID_NHOM' => $id]);
        $contentsProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'contentsProvider' => $contentsProvider,
            'devicesSearchModel' => $devicesSearchModel,
            'devicesProvider' => $devicesProvider,
        ]);
    }

    /**
     * Creates a new Nhomtbi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-nhomtb')) {
            # code...
            $model = new Nhomtbi();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'device-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhóm thiết bị ". $model->MA_NHOM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
        
    }

    public function actionCheckktnt()
    {
        $listCongviec = Noidungcongviec::findAll(['ID_NHANVIEN' => 0]);
        var_dump($listCongviec);
        echo "<br>Success!!";
    }

    
    public function actionImport()
    {
        ini_set('max_execution_time', 0);
        // $filename = 'data/tram_update.csv';
        // $handle = fopen($filename, "r");
        // // Mã trạm,Nhân viên quản lý,Điện thoại,Loại trạm
        // while (($fileop = fgetcsv($handle, 5000, ",")) !== false) 
        // {
        //     $tram = Tramvt::findOne(['MA_TRAM' => $fileop[0]]);
        //     $tram->LOAITRAM = $fileop[3];
        //     if ($fileop[1] == '#N/A') {
        //         $tram->save();
        //         continue;
        //     }
        //     if (!Nhanvien::find()->where(['TEN_NHANVIEN' => $fileop[1]])->exists()) {
        //         if (!Nhanvien::find()->where(['DIEN_THOAI' => $fileop[2]])->exists()) {
        //             $tram->ID_NHANVIEN = null;
        //             $tram->save();
        //             continue;
        //         } else {
        //             $nhanvien = Nhanvien::find()->where(['DIEN_THOAI' => $fileop[2]])->one();
        //         }
        //     } else {
        //         $nhanvien = Nhanvien::find()->where(['TEN_NHANVIEN' => $fileop[1]])->one();
        //     }
        //     $tram->ID_NHANVIEN = $nhanvien->ID_NHANVIEN;
        //     $tram->save();
        // }
        
    }

    /**
     * Updates an existing Nhomtbi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('create-nhomtb')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_NHOM]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
    }

    /**
     * Deletes an existing Nhomtbi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-nhomtb')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
        
    }

    /**
     * Finds the Nhomtbi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nhomtbi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nhomtbi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
