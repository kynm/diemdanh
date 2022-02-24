<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\AuthAssignment;
use app\models\User;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Nhanvien;
use app\models\Baohong;
use app\models\BaohongSearch;
use app\models\Dichvubaohong;
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
            $message = '<code><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . '</b></code>';
            switch ($model->status) {
                case 1:
                    $model->ngay_xl = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                    $message .= ' thông báo KHÁCH HÀNG BÁO SAI' . " \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD " . PHP_EOL;
                    break;
                case 3:
                    $message .= ' đã cập nhật HOÀN THÀNH XỬ LÝ' . " \xF0\x9F\x8C\x9E \xF0\x9F\x8C\x9E \xF0\x9F\x8C\x9E \xF0\x9F\x8C\x9E \xF0\x9F\x8C\x9E" . PHP_EOL;
                    $model->ngay_xl = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                    break;
                
                default:
                    $message .= ' ' . statusbaohong()[$model->status] . PHP_EOL;
                    break;
            }

            $model->ghichu = $params['Baohong']['ghichu'];
            $model->nv_thaotac_xl = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->save(false);
            self::tinnhanchung($model, $message);
            $message .= " \xF0\x9F\x94\x93 \xF0\x9F\x94\x93 " . 'Ghi chú xử lý: <u>' . $model->ghichu . '</u>' . PHP_EOL;
            $message .= " \xF0\x9F\x91\x89 \xF0\x9F\x91\x89 \xF0\x9F\x91\x89" . '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
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

    public function actionPhanhoixuly($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->status = $params['Baohong']['status'];
            $model->danhgia = $params['danhgia'];
            $message = '<code><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . '</b></code>';
            if ($model->status == 0) {
                $model->ngay_xl = null;
                $message .= ' đã cập nhật YÊU CẦU XỬ LÝ LẠI ' . "\xF0\x9F\x92\xA3 \xF0\x9F\x92\xA3 \xF0\x9F\x92\xA3 \xF0\x9F\x92\xA3" . PHP_EOL;
            } else {
                $message .= ' đã cập nhật ĐÓNG YÊU CẦU' . " \xF0\x9F\x8D\xBA \xF0\x9F\x8D\xBA \xF0\x9F\x8D\xBA \xF0\x9F\x8D\xBA \xF0\x9F\x8D\xBA " . PHP_EOL;
                $stringstars = "";
                for ($i=1; $i <= $model->danhgia ; $i++) { 
                    $stringstars .=  " \xE2\xAD\x90 ";
                }
                $message .= ' Độ hài lòng: ' . $stringstars . PHP_EOL;

            }
            $model->ghichu = $params['Baohong']['ghichu'];
            $model->nv_thaotac_xl = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->save(false);
            self::tinnhanchung($model, $message);
            $message .= 'Ghi chú xử lý: <u>' . $model->ghichu . '</u>' . PHP_EOL;
            $message .= " \xF0\x9F\x91\x89 \xF0\x9F\x91\x89 \xF0\x9F\x91\x89" . '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
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
            return $this->render('phanhoixuly', [
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
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['ID_DONVI' => $model->donvi_id])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            if ($model->load(Yii::$app->request->post())) {
                $arrdichvu = $model->dichvu_id;
                $model->dichvu_id = json_encode($arrdichvu);
                $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save();
                foreach($arrdichvu as $dichvu) {
                    $dv = new Dichvubaohong();
                    $dv->dichvu_id = $dichvu;
                    $dv->baohong_id = $model->id;
                    $dv->save(false);
                }
                $message = "\xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94" . PHP_EOL;
                $message .= '<code><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN. '</b></code>' . ' TẠO BÁO HỎNG' . PHP_EOL;
                self::tinnhanchung($model, $message);
                $message .= " \xF0\x9F\x91\x89 \xF0\x9F\x91\x89 \xF0\x9F\x91\x89" . '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
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
                    'dsNhanvien' => $dsNhanvien,
                ]);
            }
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

    public static function tinnhanchung($model, &$message)
    {
        $message .= " \xF0\x9F\x91\xA7 " . 'NV Báo hỏng: <strong>' . $model->nHANVIEN->TEN_NHANVIEN . '</strong>. SĐT:<u> ' . $model->nHANVIEN->DIEN_THOAI . '</u>' . PHP_EOL;
        $message .= " \xF0\x9F\x91\xA8 " .'NVKT: <strong>' . $model->nHANVIENXULY->TEN_NHANVIEN . '</strong>. SĐT:<u>' . $model->nHANVIENXULY->DIEN_THOAI . '</u>' . PHP_EOL;
        $message .= " \xF0\x9F\x92\xB0 " .'Dịch vụ: <code>' . $model->tendsdichvu . '</code>' . PHP_EOL;
        $message .= " \xF0\x9F\x91\xAA " .'Khách hàng: <code>' . $model->ten_kh . '</code> (<code>' . $model->ma_tb . '</code>)' . PHP_EOL;
        $message .= " \xF0\x9F\x93\x9E " .'SĐT: <u>' . $model->so_dt . '</u>' . PHP_EOL;
        $message .= " \xF0\x9F\x8F\xA0 " .'Địa chỉ: <strong>' . $model->diachi . '</strong>' . PHP_EOL;
        $message .= " \xF0\x9F\x92\x94 " .'Nội dung: <strong>' . $model->noidung . '</strong>' . PHP_EOL;
    }

}
