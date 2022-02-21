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
use app\models\Baohong;
use app\models\BaohongSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * BaohongController implements the CRUD actions for Baohong model.
 */
class BaohongController extends Controller
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
                    'get-Baohong' => ['POST'],
                    // 'getDai' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Baohong models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BaohongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Baohong model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionXulybaohong($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->status = $params['Baohong']['status'];
            $message = '<pre><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . '</b></pre>';
            if (in_array($model->status, [1,3])) {
                $model->ngay_xl = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                $message .= ' ' . statusbaohong()[$model->status] . PHP_EOL;
            } else {
                $message .= ' Cập nhật xử lý' . PHP_EOL;

            }
            $model->ghichu = $params['Baohong']['ghichu'];
            $model->save(false);
            $message .= 'DV: <pre>' . $model->dichvu->ten_dv . '</pre>' . PHP_EOL;
            $message .= 'KH: <pre>' . $model->ten_kh . '</pre>' . PHP_EOL;
            $message .= 'SĐT: <u>' . $model->so_dt . '</u>' . PHP_EOL;
            $message .= 'ĐC: <pre>' . $model->diachi . '</pre>' . PHP_EOL;
            $message .= 'Nội dung: <pre>' . $model->noidung . PHP_EOL;
            $message .= '</pre>Ghi chú: <pre>' . $model->ghichu . PHP_EOL;
            $message .= '</pre> <a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
            $log = new ActivitiesLog;
            $log->activity_type = 'capnhatxuly-baohong';
            $log->description = $message;
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();
            $donvi = Donvi::findOne($model->donvi_id);
            sendtelegrammessage($donvi->chatid, $message);
            return $this->redirect(['index']);
        } else {
            return $this->render('xulybaohong', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Creates a new Baohong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-baohong')) {
            $model = new Baohong();
            $model->dichvu_id = 1;
            $model->donvi_id = Yii::$app->user->identity->nhanvien->ID_DONVI;

            if ($model->load(Yii::$app->request->post())) {
                $message = '<pre><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN. '</b></pre>' . ' đã tạo báo hỏng' . PHP_EOL;
                $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->nhanvien_xl_id = 1;
                $model->save();
                $message .= 'DV: <pre>' . $model->dichvu->ten_dv . '</pre>' . PHP_EOL;
                $message .= 'KH: <pre>' . $model->ten_kh . '</pre>' . PHP_EOL;
                $message .= 'SĐT: <u>' . $model->so_dt . '</u>' . PHP_EOL;
                $message .= 'ĐC: <pre>' . $model->diachi . '</pre>' . PHP_EOL;
                $message .= 'Nội dung: <pre>' . $model->noidung . '</pre>' . PHP_EOL;
                $message .= '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
                $log = new ActivitiesLog;
                $log->activity_type = 'create-baohong';
                $log->description = $message;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                $donvi = Donvi::findOne($model->donvi_id);
                sendtelegrammessage($donvi->chatid, $message);
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            return $this->render('create', [
                'model' => $model,
                // 'authModel' => $authModel,
                'user' => $user,
            ]);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
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
        if (Yii::$app->user->can('edit-baohong')) {
            # code...
            $model = $this->findModel($id);
            $user = User::find()->where(['username' => $model->USER_NAME])->one();
            
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                // $authModel->user_id = $user->id;
                // $authModel->load($data);
                // $authModel->save(false);
                if ($data['User']['password']) {
                    $user->setPassword($data['User']['password']);
                    $user->save(false);
                }
                if ($model->ID_DONVI == 6) {
                    $assign = new AuthAssignment;
                    $assign->user_id = $model->user->id;
                    $assign->item_name = '-dotbaoduong';
                    $assign->save();
                }
                return $this->redirect(['view', 'id' => $model->ID_NHANVIEN]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    // 'authModel' => $authModel,
                    'user' => $user,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
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
        if (($model = Baohong::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
