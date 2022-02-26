<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\AuthAssignment;
use app\models\User;
use app\models\Donvi;
use app\models\Nhantin;
use app\models\NhantinSearch;
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
                    'get-tinnhan' => ['POST'],
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
        $searchModel = new NhantinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);

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
        $tinnhan = $this->findModel($id);
        if ($tinnhan) {
            return $this->render('view', [
                'model' => $tinnhan,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập hoặc báo hỏng không tồn tại');

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
            $model = new Nhantin();
            $model->dichvu_id = 1;
            $model->donvi_id = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['ID_DONVI' => $model->donvi_id])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            if ($model->load(Yii::$app->request->post())) {
                $arrdichvu = $model->dichvu_id;
                $model->dichvu_id = json_encode($arrdichvu);
                $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save();
                $message = "\xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94 \xF0\x9F\x94\x94" . ' BÁO HỎNG MỚI' . PHP_EOL;
                self::tinnhanchung($model, $message);
                $message .= " \xF0\x9F\x91\x89 \xF0\x9F\x91\x89 \xF0\x9F\x91\x89" . '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
                $donvi = Donvi::findOne($model->donvi_id);
                self::savelog($model, $message, 'create-baohong', $donvi->chatid);
               sendtelegrammessage($donvi->chatid, $message);
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'dsNhanvien' => $dsNhanvien,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionGuilaitinnhan($id, $type)
    {
        $log = ActivitiesLog::find()->where(['baohong_id' => $id, 'activity_type' => $type])->orderBy(['activity_log_id' => SORT_DESC])->one();
        if ($log) {
            sendtelegrammessage($log->chatid, $log->description);
            Yii::$app->session->setFlash('success', "Đã gửi lại tin nhắn telegram thành công!");
        } else {
            Yii::$app->session->setFlash('error', "Tin nhắn không tồn tại hoặc lỗi. Hãy liên hệ với quản trị để được hỗ trợ!");
        }
        return $this->redirect(['view', 'id' => $id]);
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

    public static function savelog($model, $message, $type, $chatid)
    {
        $log = new ActivitiesLog;
        $log->activity_type = $type;
        $log->description = $message;
        $log->baohong_id = $model->id;
        $log->chatid = $chatid;
        $log->user_id = Yii::$app->user->identity->id;
        $log->create_at = time();
        $log->save(false);
    }

}
