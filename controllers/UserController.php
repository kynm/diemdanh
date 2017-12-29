<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Nhanvien;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
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
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //fucntion to add user from Nhanvien's email

    public function actionAddUser()
    {
        $listNhanvien = Nhanvien::find()->all();
        foreach ($listNhanvien as $nhanvien) {
            if($nhanvien->USER_NAME == NULL) continue;
            $exists = User::find()->where( [ 'username' => $nhanvien->USER_NAME] )->exists();                  
            if($exists) continue;

            $user = new User;
            $user->username = $nhanvien->USER_NAME;
            $user->email = $nhanvien->USER_NAME;
            $user->setPassword('vnpt1234');
            switch ($nhanvien->CHUC_VU) {
                case 'IT':
                    $user->role = 1;
                    break;
                
                case 'Quản trị hệ thống':
                    $user->role = 1;
                    break;
                
                case 'vtt': //role 2 dành cho cán bộ vtt
                    $user->role = 2;
                    break;
                
                case 'Giám đốc Trung tâm':
                    $user->role = 3;
                    break;
                
                case 'P. GĐ Trung tâm':
                    $user->role = 3;
                    break;
                
                case 'Trưởng đài':
                    $user->role = 4;
                    break;
                
                case 'Quản lý trạm':
                    $user->role = 5;
                    break;
                                                        
                default:
                    $user->role = 6;
                    break;
            }
            $user->status = 10;
            $user->generateAuthKey();
            $user->save(false);
        }
        return $this->redirect(['index']);
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
