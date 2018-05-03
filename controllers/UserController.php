<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\AuthAssignment;
use app\models\Nhanvien;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('edit-user')) {
            # code...
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect('edit-profile');
        }
        
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('edit-user')) {
            # code...
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->redirect('edit-profile');
        }
        
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-user')) {
            # code...
            $model = new User();

            if ($model->load(Yii::$app->request->post())) {
                if(isset($model->password)) {
                    $model->setPassword($model->password);
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-user')) {
            # code...
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-user')) {
            # code...
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
        
    }

    /** 
     *  fucntion to add user access token
     */

    // public function actionUpdateToken()
    // {
    //     $users = User::find()->all();
    //     foreach ($users as $user) {
    //         $user->generateAccessToken();
            
    //         $user->save(false);
    //     }
    //     return $this->redirect(['index']);
    // }

    /**
     * Edit user infomation
     *
     * @return string
     */
    public function actionEditProfile()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => $user->username])->one();
        $alert = '';
        

        if (Yii::$app->request->post()) {
            
            //Update Nhanvien's Infomations
            $nhanvien->load(Yii::$app->request->post());
            $nhanvien->save();

            $user->load(Yii::$app->request->post());

            //Change Password
            if ($user->password != '') {
                if (Yii::$app->getSecurity()->validatePassword($user->password, $user->password_hash)) {
                    if(!($user->newPassword == '') && !($user->confirmPassword == '')) {
                        if($user->newPassword == $user->confirmPassword) {
                            $user->setPassword($user->newPassword);
                            $user->generateAccessToken();
                            $alert = 'Đổi mật khẩu thành cmn công.';
                        } else {
                            $alert = 'Mật khẩu không khớp. Vui lòng thử lại!!!';
                        }
                    } else {
                        $alert = 'Bạn cần nhập mật khẩu mới và xác nhận lại.';
                    }   
                } else {
                    $alert = 'Mật khẩu cũ không đúng';
                }
            }


            //Change Avatar
            $user->file = UploadedFile::getInstance($user, 'file');
            if (isset($user->file)) {
                $filePath = 'dist/img/' . $user->id .'_ava.' . $user->file->extension;

                //save file to host
                $user->file->saveAs($filePath);
                //save filePath to DB
                $user->avatar = $filePath;
            }
            $user->save(false);

            return $this->redirect(['edit-profile']);
        } 
        return $this->render('profile', [
            'alert' => $alert,
            'user' => $user,
            'nhanvien' => $nhanvien,
        ]);                
    }

    public function actionRoleSetting()
    {
        if (Yii::$app->user->can('create-user')) {
            # code...
            $model = new AuthAssignment;

            if ($model->load(Yii::$app->request->post())) {
                $model->save();
            }
            return $this->render('role-setting', ['model' => $model]);
            
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
        
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
