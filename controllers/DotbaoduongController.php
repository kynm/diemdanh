<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Baocao;
use app\models\Lencongviec;
use app\models\Nhanvien;
use app\models\Thietbitram;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\Dexuatnoidung;
use app\models\Noidungbaotri;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDanhsachkehoach()
    {
        $searchModel = new DotbaoduongSearch();
        $dataProvider = $searchModel->searchDskh(Yii::$app->request->queryParams);

        return $this->render('danhsachkehoach', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDanhsachthuchien()
    {
        $searchModel = new DotbaoduongSearch();
        $dataProvider = $searchModel->searchDsth(Yii::$app->request->queryParams);

        return $this->render('danhsachthuchien', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDanhsachketqua()
    {
        $searchModel = new DotbaoduongSearch();
        $dataProvider = $searchModel->searchDskq(Yii::$app->request->queryParams);

        return $this->render('danhsachketqua', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dotbaoduong model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        switch ($model->TRANGTHAI) {
            case 'Kế hoạch':
                $searchModel = new NoidungcongviecSearch();
                $dataProvider = $searchModel->searchDbd(Yii::$app->request->queryParams);

                Yii::$app->db->createCommand('
                    DELETE FROM `lencongviec`
                        WHERE ID_DOTBD = '.$id.'
                ')->execute();

                return $this->render('kehoach', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            
            case 'Đang thực hiện':
                if(isset($_REQUEST['selection'])) {
                    $keyArr = $_REQUEST['selection'];
                    
                    foreach ($keyArr as $keyObj) {
                        $key = get_object_vars(json_decode($keyObj));

                        $noidungthuchiens = Noidungcongviec::find()->where($key)->all();
                        foreach ($noidungthuchiens as $noidungthuchien) {
                            $noidungthuchien->KETQUA = 'Đạt';
                            $noidungthuchien->save(false);
                            $thietbitram = Thietbitram::find()->where(['ID_THIETBI'=>$noidungthuchien->ID_THIETBI])->one();
                            // print_r($thietbitram);
                            // die;
                            if ($thietbitram->LANBAODUONGTRUOC != date('Y-m-d')) {
                                $thietbitram->LANBD+=1;
                                $thietbitram->LANBAODUONGTRUOC = date('Y-m-d');


                                $chuky = Dexuatnoidung::find()->where(['ID_LOAITB' => $thietbitram->ID_LOAITB, 'LANBD' => $thietbitram->LANBD])->one();
                                if ($chuky) {
                                    # code...
                                    $ngaybaoduongtiep = date_create($thietbitram->NGAYSD);
                                    date_add($ngaybaoduongtiep, date_interval_create_from_date_string($chuky->cHUKYBAODUONG->value));
                                    $thietbitram->LANBAODUONGTIEP = date_format($ngaybaoduongtiep, 'Y-m-d');
                                }
                                $thietbitram->save();
                            }
                        }
                    }
                    return $this->redirect(['dotbaoduong/danhgia', 'id' => $id]);
                }

                if (Yii::$app->request->post('hasEditable')) {
                    $idKey = Yii::$app->request->post('editableKey');
                    $idKey = json_decode($idKey);
                    $arr = get_object_vars($idKey);

                    $noidungthuchien = Noidungcongviec::findOne($arr);
                    $out = Json::encode(['output' => '', 'message' => '']);
                    $post = [];
                    $posted = current($_POST['Noidungcongviec']);
                    $post['Noidungcongviec'] = $posted;

                    if ($noidungthuchien->load($post)) {
                        $noidungthuchien->save();
                    }

                    echo $out;
                    return;
                }

                $searchModel = new NoidungcongviecSearch;
                $dataProvider = $searchModel->searchDbd(Yii::$app->request->queryParams);
                return $this->render('thuchien', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            
            case 'Kết thúc':
                return $this->render('ketqua', [
                    'model' => $model = Baocao::findOne($id),
                ]);
            
            default:
                return $this->redirect('index');
        }
    }

    /**
     * Creates a new Dotbaoduong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTaodotbaoduong()
    {
        if (Yii::$app->user->can('create-dbd')) {
            
            $model = new Dotbaoduong();
            if ($model->load(Yii::$app->request->post())) {
                $model->NGAY_DUKIEN = $model->NGAY_BD;
                $model->save(false);
                $log = new ActivitiesLog;
                $log->activity_type = 'maintenance-create';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã tạo đợt bảo dưỡng ". $model->MA_DOTBD . ", ". $model->tRUONGNHOM->TEN_NHANVIEN ." làm nhóm trưởng.";
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();

                return $this->redirect(['lencongviec', 'id' => $model->ID_DOTBD]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionLencongviec($id)
    {
        $model = $this->findModel($id);

        $dexuatProvider = new ArrayDataProvider([
            'allModels' => [],
        ]);

        $allDataProvider = new ArrayDataProvider([
            'allModels' => [],
        ]);

        $selectedDataProvider = new ArrayDataProvider([
            'allModels' => [],
        ]);
        
        $infoData = NULL;    

        if (Yii::$app->request->get("idthietbi")) {
            $idthietbi = Yii::$app->request->get("idthietbi");
            $tbi = Thietbitram::findOne($idthietbi);
            
            $connection = Yii::$app->db;

            // if (Lencongviec::find()->where(['ID_DOTBD' => $id, 'ID_THIETBI'=> $idthietbi])->exists() == false) {
                $listMaND = $connection->createCommand('
                    SELECT MA_NOIDUNG
                            FROM `noidungbaotri`
                            WHERE `noidungbaotri`.ID_THIETBI = '.$tbi->ID_LOAITB.'
                ')->queryAll();
                foreach ($listMaND as $manoidung) {
                    try {
                        $connection->createCommand('
                            INSERT INTO `lencongviec` (ID_DOTBD, ID_THIETBI, MA_NOIDUNG)
                                VALUES ('.$id.', '.$idthietbi.', '.$manoidung["MA_NOIDUNG"].')
                        ')->execute();
                    } catch (\yii\db\Exception $exception) {
                        continue;
                    }
                }
            // }

            //Lay noi dung de xuat thiet bi
            $infoDexuat = Dexuatnoidung::find()->where(['ID_LOAITB' => $tbi->ID_LOAITB, 'LANBD' => $tbi->LANBD])->one();

            if (isset($infoDexuat)) {
                $infoData['LANBD'] = $infoDexuat->LANBD;
                $infoData['chuky'] = $infoDexuat->cHUKYBAODUONG->alias;

                $query = Dexuatnoidung::find()->where(['ID_LOAITB' => $tbi->ID_LOAITB, 'LANBD' => $tbi->LANBD]);

                $dexuatProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [ 
                        'pageSize' => 10,
                        'pageParam' => 'w2'
                    ],
                ]);

                //Dua noi dung de xuat vao bang len cong viec
                $connection->createCommand('
                    UPDATE `lencongviec`
                        SET IS_SUGGESTED = 1
                        WHERE ID_THIETBI = '.$idthietbi.'
                        AND MA_NOIDUNG IN 
                            ( SELECT MA_NOIDUNG FROM `dexuatnoidung` WHERE ID_LOAITB = '.$tbi->ID_LOAITB.' AND LANBD = '.$tbi->LANBD.')
                ')->execute();
            } else {
                $infoData['info'] = 'Chưa có nội dung đề xuất cho thiết bị này!!!';
            }

            /************ Them noi dung cong viec *************/
            if (Yii::$app->request->get("addkeylist")) {
                $selection = Yii::$app->request->get('addkeylist');
            
                foreach($selection as $key){            
                    
                    $congviec = Lencongviec::find()->where($key)->one();

                    $congviec->IS_SELECTED = 1;
                    
                    $congviec->save(false);
                }
            }

            /************ Xoa noi dung cong viec *************/
            if (Yii::$app->request->get("rmvkeylist")) {
                $selection = Yii::$app->request->get('rmvkeylist');
            
                foreach($selection as $key){            
                    $congviec = Lencongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->one();
                    if ($congviec) {
                        $congviec->IS_SELECTED = 0;
                        $congviec->save();
                    }
                    $noidungcongviec = Noidungcongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->one();
                    if ($noidungcongviec) {
                        $noidungcongviec->delete();
                    }
                }
            }
                    
            //Lay dataProvider unselected
            $query1 = Lencongviec::find()->where(['ID_DOTBD' => $id, 'ID_THIETBI' => $tbi->ID_THIETBI, 'IS_SELECTED' => 0]);
            $allDataProvider = new ActiveDataProvider([
                'query' => $query1,
                'pagination' => [ 
                    'pageSize' => 10,
                    'pageParam' => 'w2'
                ],
            ]);

            //Lay dataProvider noi dung duoc chon
            

            $query2 = Lencongviec::find()->where(['ID_DOTBD' => $id, 'ID_THIETBI' => $tbi->ID_THIETBI, 'IS_SELECTED' => 1]);
            $selectedDataProvider = new ActiveDataProvider([
                'query' => $query2,
                'pagination' => [ 
                    'pageSize' => 10,
                    'pageParam' => 'w3'
                ],
            ]);
        }

        return $this->render('lencongviec', [
            'model' => $model,
            'infoData' => $infoData,
            'dexuatProvider' => $dexuatProvider,
            'allDataProvider' => $allDataProvider,
            'selectedDataProvider' => $selectedDataProvider
        ]);
    }

    public function actionGiaoviec($id)
    {
        $model = $this->findModel($id);

        $lencongviecs = Lencongviec::find()->where(['ID_DOTBD' => $id])->all();
        foreach ($lencongviecs as $lencongviec) {
            if(Noidungcongviec::find()->where(['ID_DOTBD' => $lencongviec->ID_DOTBD, 'ID_THIETBI'=> $lencongviec->ID_THIETBI, 'MA_NOIDUNG' => $lencongviec->MA_NOIDUNG])->exists()) {
                $lencongviec->delete();
            }
        }

        if (Yii::$app->request->get('idnhanvien')) {
            $idnhanvien = Yii::$app->request->get('idnhanvien');

            if (Yii::$app->request->get('addkeylist')) {
                $selection = Yii::$app->request->get('addkeylist');
            
                foreach ($selection as $key) {
                    if(Noidungcongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->exists()) continue;

                    $congviec = Lencongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->one();
                    $data = $congviec->attributes;
                    $noidungcongviec = new Noidungcongviec;
                    $noidungcongviec->setAttributes($data);
                    $noidungcongviec->ID_NHANVIEN = $idnhanvien;
                    $noidungcongviec->TRANGTHAI = 'Kế hoạch';
                    $noidungcongviec->save(false);
                    $congviec->delete();
                }
            }
        }


        if (Yii::$app->request->get('rmvkeylist')) {
            $selection = Yii::$app->request->get('rmvkeylist');
        
            foreach ($selection as $key) {
                if(Lencongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->exists()) continue;

                $congviec = Noidungcongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI'=> $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG']])->one();

                $lencongviec = new Lencongviec;
                $lencongviec->ID_DOTBD = $congviec->ID_DOTBD;
                $lencongviec->ID_THIETBI = $congviec->ID_THIETBI;
                $lencongviec->MA_NOIDUNG = $congviec->MA_NOIDUNG;
                $lencongviec->IS_SELECTED = 1;
                $lencongviec->save(false);

                $congviec->delete();
            }
        }

        $query1 = Lencongviec::find()->where(['ID_DOTBD' => $id, 'IS_SELECTED' => 1]);
        $selectedDataProvider = new ActiveDataProvider([
            'query' => $query1,
            'pagination' => [ 
                'pageSize' => 10,
                'pageParam' => 'w2'
            ],
        ]);
        
        $query2 = Noidungcongviec::find()->where(['ID_DOTBD' => $id]);
        $taskDataProvider = new ActiveDataProvider([
            'query' => $query2,
            'pagination' => [ 
                'pageSize' => 10,
                'pageParam' => 'w2'
            ],
        ]);

        return $this->render('giaoviec', [
            'model' => $model,
            'selectedDataProvider' => $selectedDataProvider,
            'taskDataProvider' => $taskDataProvider
        ]);
    }

    public function actionCreatePost($MA_DOTBD, $ID_TRAMVT, $NGAY_BD, $TRUONG_NHOM)
    {
        if (Yii::$app->user->can('create-dbd')) {
            
            $model = new Dotbaoduong();
            $model->MA_DOTBD = $MA_DOTBD;
            $model->ID_TRAMVT = $ID_TRAMVT;
            $model->NGAY_BD = $NGAY_BD;
            $model->TRUONG_NHOM = $TRUONG_NHOM;
            $model->save(false);
            $log = new ActivitiesLog;
            $log->activity_type = 'maintenance-create';
            $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã tạo đợt bảo dưỡng ". $model->MA_DOTBD . ", ". $model->tRUONGNHOM->TEN_NHANVIEN ." làm nhóm trưởng.";
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new ForbiddenHttpException;
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

            $connection = Yii::$app->db;

            if ($model->load(Yii::$app->request->post())) {
                $model->NGAY_DUKIEN = $model->NGAY_BD;
                $model->save();


                //Xoa bang Len cong viec sau khi load
                $connection->createCommand('
                    DELETE FROM `lencongviec`
                        WHERE IS_SELECTED = 1
                ')->execute();

                return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
            } else {
                //Load lai bang Len cong viec
                $ndcv = Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD])->all() ;
                if ($ndcv) {
                    foreach ($ndcv as $cv) {
                        if (Lencongviec::find()->where(['ID_DOTBD' => $cv->ID_DOTBD, 'ID_THIETBI' => $cv->ID_THIETBI, 'MA_NOIDUNG' => $cv->MA_NOIDUNG])->exists()) continue;
                        
                        $connection->createCommand('
                            INSERT INTO `lencongviec` (ID_DOTBD, ID_THIETBI, MA_NOIDUNG, IS_SELECTED)
                                VALUES ('.$cv->ID_DOTBD.', '.$cv->ID_THIETBI.', '.$cv->MA_NOIDUNG.', 1)
                        ')->execute();
                        
                    }
                }
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
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
            throw new ForbiddenHttpException;
        }
    }

    public function actionThuchien($id)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);
        if ($nhanvien->ID_NHANVIEN == $dotbd->TRUONG_NHOM) {
            
            if ($dotbd->TRANGTHAI == 'Kế hoạch') {
                $dotbd->TRANGTHAI = 'Đang thực hiện';
                $dotbd->NGAY_BD = date('Y-m-d');
                $dotbd->save(false);

                $log = new ActivitiesLog;
                $log->activity_type = 'maintenance-do';
                if ($dotbd->NGAY_DUKIEN == date('Y-m-d')) {
                    $log->description = "Đợt bảo dưỡng ". $dotbd->MA_DOTBD ." đang được thực hiện bởi ". Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;
                } elseif ($dotbd->NGAY_DUKIEN < date('Y-m-d')) {
                    $log->description = "<b>Chậm tiến độ!!!</b> <br>Đợt bảo dưỡng ". $dotbd->MA_DOTBD ." đang được thực hiện bởi ". Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;
                } else {
                    $log->description = "<b>Thực hiện sớm so với kế hoạch!</b> <br>Đợt bảo dưỡng ". $dotbd->MA_DOTBD ." đang được thực hiện bởi ". Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;
                }
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();

                $noidungcongviecs = Noidungcongviec::find()->where(['ID_DOTBD' => $id])->all();
                foreach ($noidungcongviecs as $noidungcongviec) {
                    $noidungcongviec->TRANGTHAI = 'Chưa hoàn thành';
                    $noidungcongviec->KETQUA = 'Chưa đạt';
                    $noidungcongviec->save(false);               
                    // $thietbitram = Thietbitram::findOne(['ID_THIETBI' => $noidungcongviec->ID_THIETBI]);
                    // $thietbitram->LANBAODUONGTRUOC = date("y-m-d");
                    // $thietbitram->LANBD += 1;    
                }
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDanhgia($id)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);

        if ($nhanvien->ID_NHANVIEN == $dotbd->TRUONG_NHOM) {
            $model = new Baocao();

            if ($model->load(Yii::$app->request->post())) {
                $dotbd->TRANGTHAI = 'Kết thúc';
                $dotbd->save(false);

                $model->ID_DOTBD = $id;

                //get instances, upload files to host
                $model->files = UploadedFile::getInstances($model, 'files');
                $i=1;
                foreach ($model->files as $file) {
                    $filePath = 'uploads/' . $dotbd->MA_DOTBD. '_'. $i . '.' . $file->extension;

                    $file->saveAs($filePath);
                    //save file path to database
                    switch ($i) {
                        case '1':
                            $model->ANH1 = $filePath;
                            break;
                        case '2':
                            $model->ANH2 = $filePath;
                            break;
                        case '3':
                            $model->ANH3 = $filePath;
                            break;
                        
                        default:
                            break;
                    }
                    $i++;
                }

                $model->save(false);

                $log = new ActivitiesLog;
                $log->activity_type = 'maintenance-finish';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã kết thúc đợt bảo dưỡng ". $dotbd->MA_DOTBD;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();

                return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
            } else {
                return $this->render('danhgia', [
                    'model' => $model,
                    'dotbd' => $dotbd,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    // public function actionCopyDuKien()
    // {
    //     $list = Dotbaoduong::find()->all();
    //     foreach ($list as $each) {
    //         $each->NGAY_DUKIEN =$each->NGAY_BD;
    //         $each->save(false);
    //     }
    //     echo "Success";
    // }

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
