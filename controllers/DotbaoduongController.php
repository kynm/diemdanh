<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Images;
use app\models\Baoduongtong;
use app\models\Daivt;
use app\models\Lencongviec;
use app\models\Nhanvien;
use app\models\Thietbitram;
use app\models\Donvi;
use app\models\Tramvt;
use app\models\TramvtSearch;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\ProfileBaoduongNoidung;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use \yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DotbaoduongController implements the CRUD actions for Dotbaoduong model.
 */
class DotbaoduongController extends Controller
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
     * Lists all Dotbaoduong models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DotbaoduongSearch();
        $planProvider = $searchModel->searchDskh(Yii::$app->request->queryParams);
        $inprogressProvider = $searchModel->searchDsth(Yii::$app->request->queryParams);
        $finishedProvider = $searchModel->searchDskq(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'planProvider' => $planProvider,
            'inprogressProvider' => $inprogressProvider,
            'finishedProvider' => $finishedProvider
        ]);
    }


    public function actionTaoktnt($id, $start, $end)
    {
        ini_set('max_execution_time', 0);
            
        $listTram = Tramvt::find()
            ->where(['>=', 'ID_TRAM', $start])
            ->andWhere(['<', 'ID_TRAM', $end])
            ->all();
        foreach ($listTram as $tram) {
            if ($tram->ID_TRAM == 351 || $tram->ID_TRAM == 287 || $tram->ID_TRAM == 167 || $tram->ID_TRAM == 448 || $tram->ID_TRAM == 369) continue;
            $tram->taodotktnt($id);
        }
        echo "Done!";
    }

    public function actionDangKyBaoDuong()
    {
        $list_baoduongtong = Baoduongtong::find()->all(); 
        $list_nhanvien = Nhanvien::findAll(["ID_DONVI" => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        $list_tram = Tramvt::find()->joinWith("iDDAI")->where(["ID_DONVI" => Yii::$app->user->identity->nhanvien->ID_DONVI])->all();
        
        $searchModel = new TramvtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render("dang-ky-bao-duong", [
            "list_baoduongtong" => $list_baoduongtong,
            "list_nhanvien" => $list_nhanvien,
            "list_tram" => $list_tram,
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        ini_set('max_execution_time', 0);
        if (Yii::$app->user->can('create-dbd')) {
            $model = new Dotbaoduong();
            $bdt = new Baoduongtong();
            $query = Nhanvien::find()
                ->where(['>', 'ID_DONVI', 2])
                ->orderBy(['ID_DAI' => SORT_ASC]);
            if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
                $query->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
            }
            $dsNhanvien = $query->all();
            foreach ($dsNhanvien as $each) {
                $list[] = ['ID_NHANVIEN' => $each->ID_NHANVIEN, 'TEN_NHANVIEN' => $each->TEN_NHANVIEN . ' - ' . $each->chucvu->ten_chucvu .' - '. ($each->iDDAI->TEN_DAIVT ?? '')];
            }

            $listNhanvien = ArrayHelper::map($list, 'ID_NHANVIEN', 'TEN_NHANVIEN');
            if (Yii::$app->user->identity->nhanvien->ID_DONVI < 2) {
                $donVi = Donvi::find()->where(['>', 'ID_DONVI', 3])->all();
            } else {
                $donVi = Donvi::findAll(Yii::$app->user->identity->nhanvien->ID_DONVI);
            }
            $listDonvi = ArrayHelper::map($donVi, 'ID_DONVI', 'TEN_DONVI');

            $idsDai = ArrayHelper::map(Daivt::find()->where(['in', 'ID_DONVI', array_keys($listDonvi)])->all(), 'ID_DAI', 'ID_DAI');
            $listTram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_DAI', $idsDai])->all(), 'ID_TRAM', 'TEN_TRAM');
            if ($model->load(Yii::$app->request->post())) {
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1');
                $post = Yii::$app->request->post();
                
                $nhomtbi = Yii::$app->db->createCommand("
                    SELECT ID_NHOM FROM profile_baoduong_noidung JOIN noidungbaotrinhomtbi ON profile_baoduong_noidung.MA_NOIDUNG = noidungbaotrinhomtbi.MA_NOIDUNG WHERE profile_baoduong_noidung.ID_PROFILE = ".$post['profile_baoduong']." GROUP BY noidungbaotrinhomtbi.ID_NHOM
                ")->queryAll();
                $arr_nhomtbi = [];
                foreach ($nhomtbi as $each) {
                    $arr_nhomtbi[] = $each["ID_NHOM"];
                }
                $str_nhomtbi = implode(',', $arr_nhomtbi);
                $str_tram = implode(',', $post['Dotbaoduong']['ID_TRAM']);
                $sql = "SELECT DISTINCT ID_TRAM FROM `thietbitram` LEFT JOIN `thietbi` ON `thietbitram`.`ID_LOAITB` = `thietbi`.`ID_THIETBI` WHERE (`thietbi`.`ID_NHOM` IN ($str_nhomtbi)) AND (`ID_TRAM` IN ($str_tram))";
                $all = Yii::$app->db->createCommand($sql)->queryAll();
                $bdt = Baoduongtong::findOne($post['Dotbaoduong']['ID_BDT']);
                foreach ($all as $tram) {
                        $dbd = new Dotbaoduong;
                        $dbd->load($post);
                        $dbd->MA_DOTBD = $bdt->MA_BDT . '_' .$tram['ID_TRAM'];
                        $dbd->ID_TRAM = $tram['ID_TRAM'];
                        $dbd->ID_NHANVIEN = 0;
                        $dbd->CREATED_AT = time();
                        $dbd->CREATED_BY = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $dbd->save(false);
                        $dbd->taobaoduong($arr_nhomtbi, $post['profile_baoduong']);
                }
                
                return $this->redirect(['#']);
            } else {
                return $this->render('create_new', [
                    'model' => $model,
                    'listNhanvien' => $listNhanvien,
                    'listDonvi' => $listDonvi,
                    'listTram' => $listTram,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionKetthucthang($id)
    {
        ini_set('max_execution_time', 0);
        
        Yii::$app->db->createCommand('
            UPDATE `baoduongtong`
                SET `TRANGTHAI` = "ketthuc"
                WHERE `ID_BDT` = '.$id
        )->execute();
        Yii::$app->db->createCommand('
            UPDATE `dotbaoduong`
                SET `TRANGTHAI` = "chuathuchien"
                WHERE `TRANGTHAI` = "kehoach" AND `ID_BDT` = '.$id
        )->execute();
        Yii::$app->db->createCommand('
            UPDATE `dotbaoduong`
                SET `TRANGTHAI` = "chuahoanthanh"
                WHERE `TRANGTHAI` = "dangthuchien" AND `ID_BDT` = '.$id
        )->execute();
        echo "Done!";
    }

    public function actionReload($id)
    {
        if (Yii::$app->user->can("edit-tramvt")) {
            $bdt = Baoduongtong::findOne($id);
            if ($bdt->TRANGTHAI == 'dangthuchien') {
                $listDotbd = Dotbaoduong::findAll(['ID_BDT' => $id]);
                $i = 0;
                foreach ($listDotbd as $dbd) {
                    if ($dbd->ID_NHANVIEN !== $dbd->tRAMVT->ID_NHANVIEN) {
                        $dbd->ID_NHANVIEN = $dbd->tRAMVT->ID_NHANVIEN;
                        $dbd->save(false);
                        Yii::$app->db->createCommand('
                            UPDATE `noidungcongviec` 
                                SET `ID_NHANVIEN` = '.$dbd->tRAMVT->ID_NHANVIEN.' 
                                WHERE `noidungcongviec`.`ID_DOTBD` = '.$dbd->ID_DOTBD
                        )->execute();
                        $i++;
                    }
                }
                echo "Đã cập nhật quản lý cho $i trạm trong đợt KTNT này.";
            } else {
                echo "Đợt bảo dưỡng ko được phép thay đổi quản lý trạm."; exit;
            }
        } else {
            echo "Tài khoản không có quyền cập nhật.";
            exit;
        }
    }

    /**
     * Lists all Dotbaoduong Kiemtranhatram.
     * @return mixed
     */
    public function actionKiemtranhatram()
    {
        $searchModel = new DotbaoduongSearch();
        $planProvider = $searchModel->searchKtntkh(Yii::$app->request->queryParams);
        $inprogressProvider = $searchModel->searchKtntth(Yii::$app->request->queryParams);
        $finishedProvider = $searchModel->searchKtntkq(Yii::$app->request->queryParams);

        return $this->render('ktnt_index', [
            'searchModel' => $searchModel,
            'planProvider' => $planProvider,
            'inprogressProvider' => $inprogressProvider,
            'finishedProvider' => $finishedProvider
        ]);
    }

    public function actionBaocaoktnt()
    {

        if (Yii::$app->request->queryParams) {
            $id = Yii::$app->request->queryParams['ID_BDT'];
            $bdt = Baoduongtong::findOne($id);
            $searchModel = new DotbaoduongSearch();
            $dataProvider = $searchModel->searchBaocaoktnt($id, Yii::$app->request->queryParams);
            for ($i=2; $i<=7 ; $i++) {
                $each = [];
                $ttvt = Donvi::findOne($i);
                $each['name'] = $ttvt->TEN_DONVI;
                $each['id'] = $i;
                $each['labels'] = ['Kế hoạch', 'Đang thực hiện', 'Chưa thực hiện', 'Chưa hoàn thành', 'Kết thúc'];
                $sodotbaoduongtram = Dotbaoduong::find()->where(['ID_BDT' => $id])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count();
                $sodotbaoduongkehoach = Dotbaoduong::find()->where(['ID_BDT' => $id, 'TRANGTHAI' => 'kehoach'])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count();
                $sodotbaoduongdantthuchien = Dotbaoduong::find()->where(['ID_BDT' => $id, 'TRANGTHAI' => 'dangthuchien'])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count();
                $sodotbaoduongchuahoanthanh = Dotbaoduong::find()->where(['ID_BDT' => $id, 'TRANGTHAI' => 'hoan_thanh'])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count();
                $sodotbaoduonghoanthanh = Dotbaoduong::find()->where(['ID_BDT' => $id, 'TRANGTHAI' => 'ketthuc'])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count();
                $each['dataset'] = [];
                if ($sodotbaoduongtram) {
                    $each['dataset'][] = round(100 *  $sodotbaoduongkehoach / $sodotbaoduongtram, 2);
                    $each['dataset'][] = round(100 * $sodotbaoduongdantthuchien / $sodotbaoduongtram, 2);
                    $each['dataset'][] = round(100 * $sodotbaoduongchuahoanthanh / $sodotbaoduongtram, 2);
                    $each['dataset'][] = round(100 * $sodotbaoduongchuahoanthanh / $sodotbaoduongtram, 2);
                    $each['dataset'][] = round(100 * $sodotbaoduonghoanthanh / $sodotbaoduongtram, 2);
                }
                $each['tyle'] = Dotbaoduong::find()->where(['ID_BDT' => $id, 'TRANGTHAI' => 'ketthuc'])->joinWith('tRAMVT.iDDAI')->andWhere(['ID_DONVI' => $i])->count() ."/". $sodotbaoduongtram;
                $data[] = $each;
                // print_r($each); echo "<hr>";
            }
            // exit;
            return $this->render('baocaoktnt', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'data' => $data,
                'bdt' => $bdt
            ]); 
        }
        return $this->render('baocaoktnt');
    }

    /**
     * Lists all Dotbaoduong chua xu ly.
     * @return mixed
     */
    public function actionPheDuyet()
    {
        $searchModel = new DotbaoduongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pheduyet', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionPhancong($id)
    {
        $model = $this->findModel($id);
        if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            if (Yii::$app->request->post('AddSelection') && Yii::$app->request->post('ID_NHANVIEN')) {
                $selected_array = Yii::$app->request->post('AddSelection');
                foreach ($selected_array as $key) {
                    $id = get_object_vars(json_decode($key));
                    $congviec = Noidungcongviec::findOne($id);
                    $congviec->ID_NHANVIEN = Yii::$app->request->post('ID_NHANVIEN');
                    $congviec->save(false);
                }
            }
            
            $searchModel = new NoidungcongviecSearch();
            $dataProvider = $searchModel->searchDbd(Yii::$app->request->queryParams);
            $query = Nhanvien::find()
                ->where(['>', 'ID_DONVI', 2])
                ->orderBy(['ID_DAI' => SORT_ASC]);
            if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
                $query->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
            }
            $dsNhanvien = $query->all();
            return $this->render('phancong.php',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'listNhanvien' => $dsNhanvien
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
    }
    /**
     * Displays a single Dotbaoduong model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new NoidungcongviecSearch();
        $dataProvider = $searchModel->searchDbd(Yii::$app->request->queryParams);
        switch ($model->TRANGTHAI) {
            case 'kehoach':
                return $this->render('kehoach', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            
            case 'dangthuchien':
                $images = Images::find()->where(['MA_DOTBD' => $model->MA_DOTBD])->orderBy(['type' => SORT_DESC, 'ID_NHANVIEN' => SORT_ASC])->all();
                return $this->render('thuchien', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'images' => $images
                ]);
            
            default:
                $images = Images::find()->where(['MA_DOTBD' => $model->MA_DOTBD])->orderBy(['type' => SORT_DESC, 'ID_NHANVIEN' => SORT_ASC])->all();
                
                return $this->render('ketqua', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'images' => $images
                ]);
        }
    }

    /**
     * Creates a new Dotbaoduong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTaodotbaoduong()
    {
        ini_set('max_execution_time', 0);
        if (Yii::$app->user->can('create-dbd')) {
            $model = new Dotbaoduong();
            $query = Nhanvien::find()
                ->where(['>', 'ID_DONVI', 2])
                ->orderBy(['ID_DAI' => SORT_ASC]);
            if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
                $query->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
            }
            $dsNhanvien = $query->all();
            foreach ($dsNhanvien as $each) {
                $list[] = ['ID_NHANVIEN' => $each->ID_NHANVIEN, 'TEN_NHANVIEN' => $each->TEN_NHANVIEN . ' - ' . $each->chucvu->ten_chucvu .' - '. $each->iDDAI->TEN_DAIVT];
            }

            $listNhanvien = ArrayHelper::map($list, 'ID_NHANVIEN', 'TEN_NHANVIEN');
            if (Yii::$app->user->identity->nhanvien->ID_DONVI < 4) {
                $donVi = Donvi::find()->where(['>', 'ID_DONVI', 3])->all();
            } else {
                $donVi = Donvi::findAll(Yii::$app->user->identity->nhanvien->ID_DONVI);
            }
            $listDonvi = ArrayHelper::map($donVi, 'ID_DONVI', 'TEN_DONVI');
            $listTram = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM');
            if ($model->load(Yii::$app->request->post())) {
                ini_set('max_execution_time', 0);
                $post = Yii::$app->request->post();
                // var_dump($post['thietbi']); die;
                $check_exists = Baoduongtong::find()->where(['MA_BDT' => $model->MA_DOTBD])->exists();
                if ($check_exists) {
                    $baoduongtong = Baoduongtong::find()->where(['MA_BDT' => $model->MA_DOTBD])->one();
                } else {
                    $baoduongtong = new Baoduongtong;
                    $baoduongtong->MA_BDT = $model->MA_DOTBD;
                    $baoduongtong->TRANGTHAI = 'kehoach';
                    $baoduongtong->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $baoduongtong->MO_TA = $post['MO_TA'];
                    $baoduongtong->TYPE = 0;
                    $baoduongtong->save(false);
                }

                foreach ($model->ID_TRAM as $tram) {
                    $dbd = new Dotbaoduong;
                    $dbd->attributes = $model->attributes;
                    $dbd->ID_NHANVIEN = 0;
                    $dbd->MA_DOTBD = $model->MA_DOTBD ."-". $tram;
                    $dbd->ID_TRAM = $tram;
                    $dbd->ID_BDT = $baoduongtong->ID_BDT;
                    $dbd->TRANGTHAI = 'kehoach';
                    $dbd->save(false);
                }
                
                $danhsachDbd = Dotbaoduong::findAll(['ID_BDT' => $baoduongtong->ID_BDT]);

                foreach ($danhsachDbd as $each) {
                    $listThietbi = Thietbitram::find()->where(['ID_TRAM' => $each->ID_TRAM])->andWhere(['in', 'ID_LOAITB', $post['thietbi']])->all();
                    foreach ($listThietbi as $thietbi) {
                        $thietbi->congviecdinhky($each->NGAY_DUKIEN, $each->ID_DOTBD);
                    }
                }

                return $this->redirect(['#']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'listNhanvien' => $listNhanvien,
                    'listDonvi' => $listDonvi,
                    'listTram' => $listTram,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }



    /**
     * Updates an existing Dotbaoduong model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-dbd')) {
            $model = $this->findModel($id);
            $query = Nhanvien::find()
                ->where(['>', 'ID_DONVI', 2])
                ->orderBy(['ID_DAI' => SORT_ASC]);
            if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
                $query->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
            }
            $dsNhanvien = $query->all();
            foreach ($dsNhanvien as $each) {
                $list[] = ['ID_NHANVIEN' => $each->ID_NHANVIEN, 'TEN_NHANVIEN' => $each->TEN_NHANVIEN . ' - ' . $each->chucvu->ten_chucvu .' - '. $each->iDDAI->TEN_DAIVT];
            }

            $listNhanvien = ArrayHelper::map($list, 'ID_NHANVIEN', 'TEN_NHANVIEN');

            $connection = Yii::$app->db;

            if ($model->load(Yii::$app->request->post())) {
                
                $model->save(false);

                return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'listNhanvien' => $listNhanvien,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }


    /**
     * Deletes an existing Dotbaoduong model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-dbd')) {
            $this->findModel($id)->delete();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionThuchien($id)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);
        if ($nhanvien->ID_NHANVIEN == $dotbd->ID_NHANVIEN) {
            if ($dotbd->TRANGTHAI == 'kehoach') {
                $dotbd->TRANGTHAI = 'dangthuchien';
                $dotbd->NGAY_BD = date('Y-m-d');
                $dotbd->save(false);
            }
        }
        if (Yii::$app->user->can('Administrator')) {
            $dotbd->TRANGTHAI = 'dangthuchien';
                $dotbd->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionKetthuc($id)
    {
        $model = Dotbaoduong::findOne($id);
        if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN || Yii::$app->user->identity->nhanvien->chucvu->cap > 4 || Yii::$app->user->can('Administrator') ) {
            $model->TRANGTHAI = 'ketthuc';
            $model->NGAY_KT = date('Y-m-d');
            $model->save(false);

            $log = new ActivitiesLog;
            $log->activity_type = 'maintenance-finish';
            $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã kết thúc đợt bảo dưỡng ". $model->MA_DOTBD ." (tại trạm ". $model->tRAMVT->TEN_TRAM .")";
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();

            if ($model->baoduongtong->TYPE == 2) {
                $tramvt = Tramvt::findOne($model->ID_TRAM);
                $tramvt->NGAY_KTNT = $model->NGAY_KT;
                $tramvt->save(false);
            }
            return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Finds the Dotbaoduong model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dotbaoduong the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dotbaoduong::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
