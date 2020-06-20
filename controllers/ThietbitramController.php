<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Tramvt;
use app\models\Noidungcongviec;
use app\models\Dieuchuyenthietbi;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Dotbaoduong;
use app\models\Thietbi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * ThietbitramController implements the CRUD actions for Thietbitram model.
 */
class ThietbitramController extends Controller
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

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    /**
     * Lists all Thietbitram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThietbitramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Thietbitram model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $query1 = Dotbaoduong::find()->joinWith('noidungcongviecs')->where(['ID_THIETBI' => $id])->groupBy('dotbaoduong.ID_DOTBD');
        // print_r($query1); die;
        $lsbaoduongProvider = new ActiveDataProvider([
            'query' => $query1,
        ]);

        $query2 = Dieuchuyenthietbi::find()->where(['ID_THIETBI' => $id]);

        $dieuchuyenProvider = new ActiveDataProvider([
            'query' => $query2,
        ]);

        return $this->render('view', [
            'model' => $model,
            // 'transDevice' => $transDevice,
            'lsbaoduongProvider' => $lsbaoduongProvider,
            'dieuchuyenProvider' => $dieuchuyenProvider,
        ]);
    }

    /**
     * Creates a new Thietbitram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-tbitram')) {
            $model = new Thietbitram();

            if ($model->load(Yii::$app->request->post())) {
                $loaitbi = Thietbi::findone($model->ID_LOAITB);
                if ($loaitbi->ID_NHOM == 1) {
                    $json = json_encode(
                        [
                            'DINH_MUC' => 0,
                            'LOAINHIENLIEU' => 1,
                        ]);
                    $model->THAMSOTHIETBI = $json;
                }

                $model->TEN_MA = '';
                if ($model->save()) {
                    $thietbi = new Dieuchuyenthietbi;
                    $thietbi->ID_THIETBI = $model->ID_THIETBI;
                    $thietbi->NGAY_CHUYEN = $model->NGAYSD;
                    $thietbi->ID_TRAM_NGUON = null;
                    $thietbi->ID_TRAM_DICH = $model->ID_TRAM;
                    $thietbi->LY_DO = "Thêm mới<br>$model->VB";
                    $thietbi->save(false);

                    $log = new ActivitiesLog;
                    $log->activity_type = 'device-add';
                    $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm thiết bị ". $model->iDLOAITB->TEN_THIETBI ." vào trạm ". $model->iDTRAM->TEN_TRAM;
                    $log->user_id = Yii::$app->user->identity->id;
                    $log->create_at = time();
                    $log->save();
                } else {
                    var_dump($model->errors);
                    die;
                }


                return $this->redirect(['tramvt/view', 'id' => $model->ID_TRAM]);
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

    // public function actionNhap()
    // {
    //     $list = Thietbitram::find()->all();
    //     foreach ($list as $device) {
    //         $device->LANBAODUONGTIEP = date('Y-m-d', strtotime("+ 1 month", strtotime($device->LANBAODUONGTRUOC)));
    //         $device->save(false);
    //     }
    //     echo "Done!!!";
    // }

    public function actionBaoduongsaptoi()
    {
        $now = date('Y-m-d');
        $next2weeks = date('Y-m-d', strtotime("+ 2 weeks"));
        
        $query = Thietbitram::find()
        ->where(['>', 'LANBAODUONGTIEP', $now])
        ->andWhere(['<', 'LANBAODUONGTIEP', $next2weeks]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('baoduongsaptoi', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Thietbitram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('edit-tbitram')) {

            if ($model->load(Yii::$app->request->post())) {
                $input = Yii::$app->request->bodyParams;
                if (isset($input['DINH_MUC'])) {
                    $json = json_encode(
                        [
                            'DINH_MUC' => $input['DINH_MUC'],
                            'LOAINHIENLIEU' => $input['LOAINHIENLIEU'],
                        ]);
                    $model->THAMSOTHIETBI = $json;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->ID_THIETBI]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    /**
     * Deletes an existing Thietbitram model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-tbitram')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');            
        }
    }

    public function actionLists($id) //không quan trọng
    {
        $dotbaoduong = Dotbaoduong::find()
        ->where(['ID_DOTBD'=>$id])
        ->one();

        $thietbi = Thietbitram::find()
        ->where(['ID_TRAM' => $dotbaoduong->ID_TRAM])
        ->all();

        if(isset($thietbi) && count($thietbi)>0) {
            echo "<option>Chọn thiết bị</option>";
            foreach($thietbi as $each) {
                $loaitb = Thietbi::find()
                ->where(['ID_THIETBI' => $each->ID_LOAITB])
                ->one();
                echo "<option value='".$each->ID_THIETBI."'>".$each->iDLOAITB->TEN_THIETBI."</option>";
            }
            return;
        }else {
            echo "-";
        }
    }

    public function actionSearch($donvi='', $dai='', $thietbi='')
    {
        $arr = explode(',', $thietbi);
        
        $query = Tramvt::find()->joinWith('thietbitrams')->joinWith('iDDAI')
        ->andWhere(['in', 'thietbitram.ID_LOAITB', $arr]);
        
        if ($donvi !== '') {
            if ($dai == "") {
                $query->andWhere(['daivt.ID_DONVI' => $donvi]);
                
            } else {
                $query->andWhere(['tramvt.ID_DAI' => $dai]);
            }
        }
        $danhsachtram = $query->all();
        foreach($danhsachtram as $each) {
            echo "<option value='".$each->ID_TRAM."'>".$each->TEN_TRAM."</option>";
        }
        return;
    }

    public function actionImp() {
        ini_set('max_execution_time', 0);
        $fileName = "data/MANE_OLT.xlsx";
        $data = \moonland\phpexcel\Excel::import($fileName, [
            'setFirstRecordAsKeys' => true,
            'setIndexSheetByName' => true,
            // 'getOnlySheet' => 'dsBTS',
        ]);
        // var_dump($data["MAN-E"]); exit;
        $ma_olt = 7;
        $ma_mane = 8;

        foreach ($data["OLT"] as $device) {
            // var_dump($device); die;
            // var_dump($device["TypeDevice"]); die;
            
            if (is_null($tramvt = Tramvt::findOne(["TEN_TRAM" => $device["Trạm VT"]]))) {
                if (is_null($tramvt = Tramvt::findOne(["TEN_TRAM" => str_replace("Trạm ", "", $device["Trạm VT"])]))) {
                    echo $device["Trạm VT"]." không tìm thấy trong CSDL.<br>";
                    continue;
                }
            }
            if (is_null($thietbi = Thietbi::findOne(["MA_THIETBI" => $device["Hardware"]]))) {
                $thietbi = new Thietbi;
            }
            $thietbi->MA_THIETBI = $device["Hardware"];
            $thietbi->TEN_THIETBI = $device["Hardware"];
            $thietbi->ID_NHOM = 7;
            $thietbi->HANGSX = $device["Hãng"];
            $thietbi->THONGSOKT = "Type Device: ".$device["TypeDevice"];
            $thietbi->save();

            if (is_null($thietbitram = Thietbitram::findOne(["ID_LOAITB" => $thietbi->ID_THIETBI, "ID_TRAM" => $tramvt->ID_TRAM]))) {
                $thietbitram = new Thietbitram;
                $thietbitram->ID_LOAITB = $thietbi->ID_THIETBI;
                $thietbitram->ID_TRAM = $tramvt->ID_TRAM;
                $thietbitram->TEN_MA = $device["SYSNAME"];
                is_null( $device["IP ADDRESS"]) ? $thietbitram->SERIAL_MAC = md5(uniqid()) : $thietbitram->SERIAL_MAC = $device["IP ADDRESS"];
                $thietbitram->NGAYSX = "2019/01/01";
                $thietbitram->NGAYSD = "2019/01/01";
                
                if ($thietbitram->save()) {
                    echo "Thêm thành công thiết bị $thietbitram->TEN_MA cho trạm ". $device["Trạm VT"] ."<br>";
                } else {
                    echo "Thêm thiết bị cho trạm ". $device["Trạm VT"] ." không thành công<br>";
                    var_dump($thietbitram->errors);
                }
            } else {
                echo "Đã có thiết bị ". $thietbitram->TEN_MA ."<br>";
            }
        }
        exit;
    }

    public function actionImport()
    {
        ini_set('max_execution_time', 0);
        $fileName = "data/BTS.xlsx";
        $data = \moonland\phpexcel\Excel::import($fileName, [
            'setFirstRecordAsKeys' => true,
            'setIndexSheetByName' => true,
            'getOnlySheet' => 'dsBTS',
        ]);
        foreach ($data as $element) {
            // var_dump($element); die;
            $tramvt = Tramvt::findOne(['MA_TRAM' => $element['CSHT']]);
            if (is_null($tramvt)) {
                echo $element['CSHT'] . ' không tìm thấy trong CSDL<br>';
                continue;
            }
            $tramvt->TEN_TRAM2 = $element['Ten2'];
            $tramvt->save();
            if (!is_null($element['2G'])) {
                $tbi2g = new Thietbitram();
                $tbi2g->ID_LOAITB = 112;
                $tbi2g->ID_TRAM = $tramvt->ID_TRAM;
                $tbi2g->TEN_MA = $element['2G'];
                $tbi2g->SERIAL_MAC = md5(uniqid());
                $tbi2g->NGAYSX = '2018-01-01';
                $tbi2g->NGAYSD = '2018-01-01';
                $tbi2g->save(false);
            }
            if (!is_null($element['3G'])) {
                $tbi3g = new Thietbitram();
                $tbi3g->ID_LOAITB = 113;
                $tbi3g->ID_TRAM = $tramvt->ID_TRAM;
                $tbi3g->TEN_MA = $element['3G'];
                $tbi3g->SERIAL_MAC = md5(uniqid());
                $tbi3g->NGAYSX = '2018-01-01';
                $tbi3g->NGAYSD = '2018-01-01';
                $tbi3g->save(false);
            }
            if (!is_null($element['4G'])) {
                $tbi4g = new Thietbitram();
                $tbi4g->ID_LOAITB = 114;
                $tbi4g->ID_TRAM = $tramvt->ID_TRAM;
                $tbi4g->TEN_MA = $element['4G'];
                $tbi4g->SERIAL_MAC = md5(uniqid());
                $tbi4g->NGAYSX = '2018-01-01';
                $tbi4g->NGAYSD = '2018-01-01';
                $tbi4g->save(false);
            }
        }
    }

    public function actionAddCsht($begin)
    {
        $list_tram = Tramvt::find()->where(['>', 'ID_TRAM', $begin])->asArray()->all();
        // var_dump($list_tram); exit;
        foreach ($list_tram as $tram) {
            if(is_null(Thietbitram::findOne(['ID_TRAM' => $tram['ID_TRAM'], 'ID_LOAITB' => 111]))) {
                $csht = new Thietbitram;
                $csht->ID_LOAITB = 111;
                $csht->ID_TRAM = $tram['ID_TRAM'];
                $csht->SERIAL_MAC = $tram['MA_TRAM'];
                $csht->NGAYSX = "2019-06-01";
                $csht->NGAYSD = "2019-06-01";
                $csht->save(false);
            } else {
                echo "Đã có CSHT <br>";
            }
        }
        exit;
    }

    /**
     * Finds the Thietbitram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thietbitram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thietbitram::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
