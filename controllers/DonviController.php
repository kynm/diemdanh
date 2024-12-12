<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Donvi;
use app\models\Nhanvien;
use app\models\User;
use app\models\Lophoc;
use app\models\Hocsinh;
use app\models\UploadForm;
use app\models\DonviSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\AuthAssignment;
use yii\web\UploadedFile;

/**
 * DonviController implements the CRUD actions for Donvi model.
 */
class DonviController extends Controller
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
     * Lists all Donvi models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('Administrator')) {
            $searchModel = new DonviSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }  
    }

    /**
     * Displays a single Donvi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('Administrator')) {
            $model = $this->findModel($id);
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        } 
    }

    /**
     * Creates a new Donvi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-donvi')) {
            $model = new Donvi();
                $model->HP_T = 1;
            if ($model->load(Yii::$app->request->post())) {
                $model->SO_DT = trim($model->SO_DT);
                $model->TEN_DONVI = trim($model->TEN_DONVI);
                $model->NGAY_BD = date('Y-m-d');
                $model->save(false);
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm đơn vị ". $model->TEN_DONVI;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                self::khoitaotaikhoannhanvien($model);
                return $this->redirect(['view', 'id' => $model->ID_DONVI]);
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
     * Updates an existing Donvi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('Administrator')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                Yii::$app->session->setFlash('success', "CẬP NHẬT THÀNH CÔNG!");
                return $this->redirect(['view', 'id' => $model->ID_DONVI]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function khoitaotaikhoannhanvien($donvi)
    {
        if (Yii::$app->user->can('Administrator')) {
            if (!$donvi->nhanviens) {
                // TẠO TÀI KHOẢN QUẢN TRỊ
                $nhanvien = Nhanvien::find()->where(['USER_NAME' => $donvi->SO_DT])->one();
                if(!$nhanvien) {
                    $nhanvien = new Nhanvien();
                    $nhanvien->ID_DONVI = $donvi->ID_DONVI;
                    $nhanvien->MA_NHANVIEN = $donvi->SO_DT;
                    $nhanvien->TEN_NHANVIEN = 'QUẢN LÝ - ' . $donvi->TEN_DONVI;
                    $nhanvien->DIEN_THOAI = $donvi->SO_DT;
                    $nhanvien->USER_NAME = $donvi->SO_DT;
                    $nhanvien->save();
                    $user = new User;
                    $user->username = trim($nhanvien->USER_NAME);
                    $user->email = $nhanvien->USER_NAME."@diemdanh.online";
                    $user->setPassword($user->username);
                    $user->generateAuthKey();
                    $user->status = 10;
                    $user->created_at = time();
                    $user->save(false);
                    $assign = new AuthAssignment;
                    $assign->user_id = $user->id;
                    $assign->item_name = 'quanlytruonghoc';
                    $assign->save(false);
                    $assign = new AuthAssignment;
                    $assign->user_id = $user->id;
                    $assign->item_name = 'diemdanhlophoc';
                    $assign->save(false);
                }

                // TẠO TÀI KHOẢN ĐIỂM DANH
                $nhanvien1 = Nhanvien::find()->where(['USER_NAME' => $donvi->SO_DT . 'diemdanh'])->one();
                if(!$nhanvien1) {
                    $nhanvien1 = new Nhanvien();
                    $nhanvien1->ID_DONVI = $donvi->ID_DONVI;
                    $nhanvien1->MA_NHANVIEN = $donvi->SO_DT . 'diemdanh';
                    $nhanvien1->TEN_NHANVIEN = 'ĐIỂM DANH - ' . $donvi->TEN_DONVI;
                    $nhanvien1->DIEN_THOAI = $donvi->SO_DT;
                    $nhanvien1->USER_NAME = $donvi->SO_DT . 'diemdanh';
                    $nhanvien1->save();
                    $user1 = new User;
                    $user1->username = trim($nhanvien1->USER_NAME);
                    $user1->email = $nhanvien1->USER_NAME."@diemdanh.online";
                    $user1->setPassword($user1->username);
                    $user1->generateAuthKey();
                    $user1->status = 10;
                    $user1->created_at = time();
                    $user1->save(false);
                    $assign = new AuthAssignment;
                    $assign->user_id = $user1->id;
                    $assign->item_name = 'diemdanhlophoc';
                    $assign->save(false);
                }
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing Donvi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-donvi')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        } 
    }

    /**
     * Finds the Donvi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donvi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Donvi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImportlophochocsinh($id) {
        if (Yii::$app->user->can('Administrator') && $id) {
            $model = new UploadForm();
            if (Yii::$app->request->post())
            {
                $params = Yii::$app->request->bodyParams;
                $model->fileupload = UploadedFile::getInstance($model, 'fileupload');
                $data = \moonland\phpexcel\Excel::import($model->fileupload->tempName);
                $keys = array_keys($data[0]);
                $arrkeyCheck = ['TEN_LOP', 'HO_TEN', 'ID_NHANVIEN_DIEMDANH'];
                if (array_diff($arrkeyCheck, $keys)) {
                    Yii::$app->session->setFlash('error', "Cập nhật không thành công. Thiếu trường: " . implode(',', array_diff($arrkeyCheck, $keys)));
                    return $this->redirect(['importlophochocsinh']);
                }
                $i = 0;
                foreach ($data as $key => $value) {
                    if ($value['TEN_LOP'] && $value['TEN_LOP']) {
                        $lop = Lophoc::find()->where(['ID_DONVI' => $id])->andWhere(['TEN_LOP' => $value['TEN_LOP']])->one();
                        if (!$lop) {
                            $lop = new Lophoc();
                            $lop->ID_DONVI = $id;
                            $lop->MA_LOP = $model->ID_DONVI . '-' . $id . '-' . rand_string(4);;
                            $lop->TEN_LOP = $value['TEN_LOP'];
                            $lop->ID_NHANVIEN_DIEMDANH = $value['ID_NHANVIEN_DIEMDANH'];
                            $lop->save();
                            if ($lop->errors) {
                                die(var_dump($lop->errors));
                            }
                        }
                        $hocsinh = Hocsinh::find()->where(['ID_DONVI' => $id])->andWhere(['ID_LOP' => $lop->ID_LOP])->andWhere(['HO_TEN' => $value['HO_TEN']])->one();
                        
                        if (!$hocsinh) {
                            $hocsinh = new Hocsinh();
                            $hocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                            $hocsinh->ID_DONVI = $id;
                            $hocsinh->ID_LOP = $lop->ID_LOP;
                            $hocsinh->MA_HOCSINH  = $lop->MA_LOP . '-' . ($lop->getDshocsinh()->count() + 1);
                            $hocsinh->HO_TEN = $value['HO_TEN'];
                            $hocsinh->NGAY_SINH = date('Y-m-d',strtotime($value['NGAY_SINH']));
                            $hocsinh->DIA_CHI = $value['DIA_CHI'];
                            $hocsinh->SO_DT = $value['SO_DT'] ? $value['SO_DT'] : '';
                            $hocsinh->save();
                            if ($hocsinh->errors) {
                                die(var_dump($hocsinh->errors));
                            }
                            $i ++;
                        }
                    }
                }
                Yii::$app->session->setFlash('success', "Khởi tạo thành công " . $i . ' Khách hàng!');
                return $this->redirect(['view', 'id' => $id]);
            }

            return $this->render('importlophochocsinh', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionTheodoisolieu()
    {
        $sqlhocsinhtaotrongngay = "SELECT a.TEN_DONVI,a.SO_DT,count(1) SOLUONG from donvi a, hocsinh b where a.ID_DONVI = b.ID_DONVI and date(b.created_at) = CURRENT_DATE() GROUP by a.TEN_DONVI,a.SO_DT ORDER BY SOLUONG DESC";
        $hocsinhtaotrongngay = Yii::$app->db->createCommand($sqlhocsinhtaotrongngay)->queryAll();
        return $this->render('theodoisolieu', [
                'hocsinhtaotrongngay' => $hocsinhtaotrongngay,
            ]);
    }

}
