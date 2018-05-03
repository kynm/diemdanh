<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\AuthAssignment;
use app\models\User;
use app\models\Daivt;
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
            $authModel = new AuthAssignment;
            $user = new User;

            if ($model->load(Yii::$app->request->post())) {
                if (!Nhanvien::find()->where(['MA_NHANVIEN' =>$model->MA_NHANVIEN])->exists()) {
                    if (User::find()->where(['username' => $model->USER_NAME])->exists() == false) {
                        //Luu thong tin nhan vien
                        $model->save();
                        
                        //Luu tai khoan
                        // print_r($model->ID_NHANVIEN);
                        // die;

                        // $user = new User;
                        $user->username = $model->USER_NAME;
                        $user->email = $model->USER_NAME;
                        $user->setPassword('vnpt1234');
                        $user->generateAuthKey();
                        $user->generateAccessToken();
                        $user->status = 10;
                        $user->save(false);
                        

                        //Luu log them nhan vien
                        $log = new ActivitiesLog;
                        $log->activity_type = 'user-add';
                        $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhân viên ". $model->TEN_NHANVIEN;
                        $log->user_id = Yii::$app->user->identity->id;
                        $log->create_at = time();
                        $log->save();
                        return $this->redirect(['view', 'id' => $model->ID_NHANVIEN]);
                    }
                }
            } 
            return $this->render('create', [
                'model' => $model,
                'authModel' => $authModel,
                'user' => $user,
            ]);
        } else {
            # code...
            throw new ForbiddenHttpException;
            
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
            
            // print_r($user);
            // die;
            if (!AuthAssignment::find()->where(['user_id' => $user->id])->exists()) {
                $authModel = new AuthAssignment;
            } else {
                $authModel = AuthAssignment::find()->where(['user_id' => $user->id ])->one();
            }
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                $authModel->user_id = $user->id;
                $authModel->load($data);
                $authModel->save(false);
                if ($data['User']['password']) {
                    $user->setPassword($data['User']['password']);
                    $user->save(false);
                }
                return $this->redirect(['view', 'id' => $model->ID_NHANVIEN]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'authModel' => $authModel,
                    'user' => $user,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;
            
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
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException;
            
        }
        
    }

    public function actionMultiDelete()
    {
        $nhanviens = Nhanvien::find()->where(['USER_NAME' => ''])->all();
        foreach ($nhanviens as $nhanvien) {
            $nhanvien->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionList($id) {
        // $out = [];
        // if (isset($_POST['depdrop_parents'])) {
        //     $id_donvi = end($_POST['depdrop_parents']);
        //     $list = Daivt::find()->select('ID_DAI, TEN_DAIVT')->where(['ID_DONVI'=>$id_donvi])->asArray()->all();
        //     $selected  = null;
        //     if ($id_donvi != null && count($list) > 0) {
        //         $selected = '';
        //         foreach ($list as $i => $daivt) {
        //             $out[] = ['ID_DAI' => $daivt['ID_DAI'], 'TEN_DAIVT' => $daivt['TEN_DAIVT']];
        //             if ($i == 0) {
        //                 $selected = $daivt['ID_DAI'];
        //             }
        //         }
        //         // var_dump($out);
        //         // echo '<hr>';
        //         // var_dump($selected);
        //         // die;
        //         echo Json::encode(['output' => $out, 'selected'=>$selected]);
        //         return;
        //     }
        // }
        // echo Json::encode(['output' => '', 'selected'=>'']);
        $danhsachdai = Daivt::find()
        ->where(['ID_DONVI' => $id])
        ->all();
        // var_dump($danhsachdai);
        // die;

        if(isset($danhsachdai) && count($danhsachdai)>0) {
            echo "<option value=''>Chọn đài viễn thông</option>";
            foreach($danhsachdai as $each) {
                echo "<option value='".$each->ID_DAI."'>".$each->TEN_DAIVT."</option>";
            }
            return;
        }else {
            echo "<option value=''>Chọn đài viễn thông</option>";
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
