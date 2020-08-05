<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Chontbidieuchuyen;
use app\models\Dieuchuyenthietbi;
use app\models\Tramvt;
use app\models\TramvtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

/**
 * TramvtController implements the CRUD actions for Tramvt model.
 */
class TramvtController extends Controller
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
        $searchModel = new TramvtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShow()
    {
        $list_tram = Tramvt::find()->all();
        echo '<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã CSHT</th>
                <th>Mã quản lý</th>
                <th>Tên</th>
                <th>Địa điểm</th>
                <th>Tọa độ</th>
                <th>Đài</th>
                <th>Trung tâm</th>
                <th>Nhân viên</th>
                <th>Điện thoại</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($list_tram as $tram) {
            echo "<tr>
            <td>" . $tram->MA_TRAM . "</td>
            <td>" . $tram->TEN_TRAM2 . "</td>
            <td>" . $tram->TEN_TRAM . "</td>
            <td>" . $tram->DIADIEM . "</td>
            <td>" . $tram->VI_DO .','. $tram->KINH_DO . "</td>
            <td>" . $tram->iDDAI->TEN_DAIVT . "</td>
            <td>" . $tram->iDDAI->iDDONVI->TEN_DONVI . "</td>
            <td>" . $tram->iDNHANVIEN->TEN_NHANVIEN . "</td>
            <td>" . $tram->iDNHANVIEN->DIEN_THOAI . "</td>
        </tr>";
        }
        echo '</tbody>
        </table>';
        exit;
    }

    /**
     * Displays a single Tramvt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->get()) {
            switch (Yii::$app->request->get('action')) {
                case '1':
                    return $this->redirect(['thietbitram/create', 'id_tram' => $id]);
                    
                case '2':
                    if (Yii::$app->request->get('selection')) {
                        $selection = Yii::$app->request->get('selection');
                        
                        foreach ($selection as $key) {
                            $tbidieuchuyen = new Chontbidieuchuyen;
                            $tbidieuchuyen->ID_THIETBI = $key;
                            $tbidieuchuyen->ID_TRAM_NGUON = $id;
                            $tbidieuchuyen->save();
                        }

                        return $this->redirect(['tramvt/dieuchuyen', 'id' => $id]);
                    }
                    break;

                case '3':
                    if (Yii::$app->request->get('selection')) {
                        $selection = Yii::$app->request->get('selection');

                        foreach ($selection as $key) {
                            $thietbitram = Thietbitram::find()->where(['ID_THIETBI' => $key])->one();
                            $thietbitram->delete();
                        }
                    }
                    break;
                
                default:
                    
                    break;
            }
        }

        $searchModel = new ThietbitramSearch();
        $dataProvider = $searchModel->searchTram(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tramvt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-tramvt')) {
            $model = new Tramvt();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm đơn vị ". $model->MA_TRAM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['view', 'id' => $model->ID_TRAM]);
            } else {
                return $this->render('create', [
                    'model' => $model,
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
        if (Yii::$app->user->can('edit-tramvt')) {
            $model = $this->findModel($id);
            $nhanvien = Nhanvien::findOne($model->ID_NHANVIEN);
            
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-update';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã cập nhật nhà trạm ". $model->TEN_TRAM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'nhanvien' => $nhanvien
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    /**
     * Dieu chuyen nhieu thiet bi trong tram
    **/
    public function actionDieuchuyen($id)
    {
        if (Yii::$app->user->can('edit-tramvt')) {
            $model = $this->findModel($id);

            if (Yii::$app->request->post('idtramdich')) {
                $idtramdich = Yii::$app->request->post('idtramdich');
                $lydodieuchuyen = Yii::$app->request->post('lydodieuchuyen');
                $ngaychuyen = Yii::$app->request->post('ngaychuyen');
                if (Yii::$app->request->post('addkeylist')) {
                    $selection = Yii::$app->request->post('addkeylist');
                    
                    foreach ($selection as $key) {
                        $tbidieuchuyen = Chontbidieuchuyen::findOne($key);
                        $tbidieuchuyen->ID_TRAM_DICH = $idtramdich;
                        $tbidieuchuyen->NGAY_CHUYEN = $ngaychuyen;
                        $tbidieuchuyen->LY_DO = $lydodieuchuyen;
                        $tbidieuchuyen->IS_SELECTED = 1;
                        $tbidieuchuyen->save(false);
                    }
                }
            }

            if (Yii::$app->request->post('rmvkeylist')) {
                $selection = Yii::$app->request->post('rmvkeylist');
            
                foreach ($selection as $key) {
                    $tbidieuchuyen = Chontbidieuchuyen::findOne($key);
                    $tbidieuchuyen->ID_TRAM_DICH = NULL;
                    $tbidieuchuyen->NGAY_CHUYEN = NULL;
                    $tbidieuchuyen->LY_DO = NULL;
                    $tbidieuchuyen->IS_SELECTED = 0;
                    $tbidieuchuyen->save(false);
                }
            }

            $query1 = Chontbidieuchuyen::find()->where(['IS_SELECTED' => 0]);
            $unselectedProvider = new ActiveDataProvider([
                'query' => $query1,
            ]);

            $query2 = Chontbidieuchuyen::find()->where(['IS_SELECTED' => 1]);
            $selectedProvider = new ActiveDataProvider([
                'query' => $query2,
            ]);

            return $this->render('dieuchuyen', [
                'model' => $model,
                'unselectedProvider' => $unselectedProvider,
                'selectedProvider' => $selectedProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionHoantatdieuchuyen($id)
    {
        $selectedDevices = Chontbidieuchuyen::find()->where(['IS_SELECTED' => 1])->all();
        foreach ($selectedDevices as $device) {
            $tbi = new Dieuchuyenthietbi;
            $tbi->ID_THIETBI = $device->ID_THIETBI;
            $tbi->NGAY_CHUYEN = $device->NGAY_CHUYEN;
            $tbi->ID_TRAM_NGUON = $device->ID_TRAM_NGUON;
            $tbi->ID_TRAM_DICH = $device->ID_TRAM_DICH;
            $tbi->LY_DO = $device->LY_DO;

            $tbi->save(false);

            $tbitram = Thietbitram::findOne($device->ID_THIETBI);
            $tbitram->ID_TRAM = $device->ID_TRAM_DICH;
            $tbitram->save(false);
        }

        Chontbidieuchuyen::deleteAll();

        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * Deletes an existing Tramvt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-tramvt')) {
            $tramvt = $this->findModel($id);
            $tramvt->IS_DELETE = 1;
            $tramvt->save(false);
            //$this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionSearch($donvi, $dai)
    {
        if ($donvi == '') {
            $danhsachtram = Tramvt::find()->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
            return;
        }
        if ($dai == "") {
            $danhsachtram = Tramvt::find()->joinWith('iDDAI')->where(['daivt.ID_DONVI' => $donvi])->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
        } else {
            $danhsachtram = Tramvt::find()->where(['ID_DAI' => $dai])->all();
            foreach($danhsachtram as $each) {
                echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
            }
        }
        return;
    }

    public function actionUpdateFromExcel()
    {
        ini_set('max_execution_time', 0);
        $fileName = 'data/BTS.xlsx';
        $data = \moonland\phpexcel\Excel::import($fileName, [
            'setFirstRecordAsKeys' => true, 
            'setIndexSheetByName' => true, 
            'getOnlySheet' => 'CSHT', 
        ]);
        
        $count = 0;
        foreach ($data as $row) {
            // var_dump($row); die;
            $model = Tramvt::findOne(['MA_TRAM' => $row["MaCSHT"]]);
            // var_dump($model); die;
            if (is_null($model = Tramvt::findOne(['MA_TRAM' => $row["MaCSHT"]]))) {
                echo "Chưa có trạm ".$row["CSHT"];
                $model = new Tramvt;
                $model->MA_TRAM = $row["MaCSHT"];
                $model->TEN_TRAM = $row["CSHT"];
                // $model->TEN_TRAM2 = $row["Mã CSHT"];
                $model->DIADIEM = $row["DiaChi"];
                $model->QUANHUYEN = $row["Quan"];
                $model->XAPHUONG = $row["Xa"];
                $model->NGAYHD = date('Y-m-d', strtotime($row["NgayHD"]));
                $model->KINH_DO = $row["Longitude"];
                $model->VI_DO = $row["Latitude"];
                $model->ID_DAI = $row["Dai"];
                $model->ID_NHANVIEN = 0;
                $model->LOAITRAM = $row["Nhom"];
                // $model->KIEUTRAM = "";
                $model->save();
                echo " - Đã thêm<br>";
                $count++;
                continue;
            } else {
                echo "Đã có trạm ".$row["CSHT"]."<br>";
                $model->QUANHUYEN = $row["Quan"];
                $model->XAPHUONG = $row["Xa"];
                $model->NGAYHD = date('Y-m-d', strtotime($row["NgayHD"]));
                $model->save(false);
            }
        }
        echo "Done! $count trạm đc thêm!"; exit;
    }
    /**
     * Finds the Tramvt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tramvt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tramvt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
