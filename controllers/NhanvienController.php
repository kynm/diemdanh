<?php

namespace app\controllers;

use Yii;
use app\models\Temp;
use app\models\ActivitiesLog;
use app\models\AuthAssignment;
use app\models\User;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Tramvt;
use app\models\Nhanvien;
use app\models\NhanvienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * NhanvienController implements the CRUD actions for Nhanvien model.
 */
class NhanvienController extends Controller
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
                    'get-nhanvien' => ['POST'],
                    // 'getDai' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Nhanvien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NhanvienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nhanvien model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nhanvien model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-nhanvien')) {
            # code...
            $model = new Nhanvien();
            // $authModel = new AuthAssignment;
            $user = new User;

            if ($model->load(Yii::$app->request->post())) {
                    if (User::find()->where(['username' => $model->USER_NAME])->exists() == false) {
                        $model->save();
                        $user->username = trim($model->USER_NAME);
                        $user->email = $model->USER_NAME."@diemdanh.online";
                        $user->setPassword($user->username);
                        $user->generateAuthKey();
                        $user->status = 10;
                        $user->created_at = time();
                        $user->save(false);

                        //Luu log them nhan vien
                        $log = new ActivitiesLog;
                        $log->activity_type = 'user-add';
                        $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhân viên ". $model->TEN_NHANVIEN;
                        $log->user_id = Yii::$app->user->identity->id;
                        $log->create_at = time();
                        $log->save();
                        return $this->redirect(['index']);
                    }
                // }
            } 
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
        
    }

    public function actionGenerateUser()
    {
        $models = Nhanvien::find()->all();
        foreach ($models as $model) {
            $user = new User;
            $user->username = $model->USER_NAME;
            $user->email = $model->USER_NAME."@diemdanh.online";
            $user->setPassword('Diemdanh@123');
            $user->generateAuthKey();
            $user->status = 10;
            $user->created_at = time();
            $user->save(false);
        }
    }

    /**
     * Updates an existing Nhanvien model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-nhanvien')) {
            # code...
            $model = $this->findModel($id);
            $user = User::find()->where(['username' => $model->USER_NAME])->one();
            
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save(false)) {
                $password = trim($data['User']['password']);
                if ($password) {
                    if (!in_array($data['User']['password'], except_pass())) {
                        $user->setPassword($password);
                        $user->save(false);
                        Yii::$app->session->setFlash('success', "Cập nhật mật khẩu thành công!");
                        return $this->redirect(['view', 'id' => $model->ID_NHANVIEN]);
                    } else {
                        Yii::$app->session->setFlash('error', "Mật khẩu bảo mật kém, không thể cập nhật!");
                    }
                }

                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
                return $this->redirect(['view', 'id' => $model->ID_NHANVIEN]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
        
    }

    /**
     * Deletes an existing Nhanvien model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-nhanvien')) {
            # code...
            $model = $this->findModel($id);
            $user = User::findOne(['username' => $model->USER_NAME]);
            $user->delete();
            $model->delete();
            
            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
        
    }

    public function actionList($id) {
        $danhsachdai = Daivt::find()
        ->where(['ID_DONVI' => $id])
        ->all();

        if(isset($danhsachdai) && count($danhsachdai)>0) {
            echo "<option value=''>Chọn lớp</option>";
            foreach($danhsachdai as $each) {
                echo "<option value='".$each->ID_LOP."'>".$each->TEN_LOP."</option>";
            }
            return;
        }else {
            echo "<option value=''>Chọn lớp</option>";
        }
    }

    public function actionListnvdonvi($id) {
        $danhsachnhanvien = Nhanvien::find()
        ->where(['ID_DONVI' => $id])
        ->all();

        if(isset($danhsachnhanvien) && count($danhsachnhanvien)>0) {
            echo "<option value=''>Chọn lớp</option>";
            foreach($danhsachnhanvien as $each) {
                echo "<option value='".$each->ID_NHANVIEN."'>".$each->TEN_NHANVIEN."</option>";
            }
            return;
        }else {
            echo "<option value=''>Chọn lớp</option>";
        }
    }

    public function actionGanquyen()
    {
        ini_set('max_execution_time', 0);
        $list = Nhanvien::find()->all();
        foreach ($list as $nhanvien) {
            if ($nhanvien->ID_DONVI == 6) {
                $assign = new AuthAssignment;
                $assign->user_id = $nhanvien->user->id;
                $assign->item_name = '-dotbaoduong';
                $assign->save();
            }
        }
    }

    /**
     * Finds the Nhanvien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Nhanvien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nhanvien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
