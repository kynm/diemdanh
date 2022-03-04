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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBaocaotheonhanvienxuly()
    {
        $params = Yii::$app->request->queryParams;
        $type = isset($params['type']) ? $params['type'] : 6;
        $searchModel = new BaohongSearch();
        $baocaotheonhanvienxuly = $searchModel->baocaotheonhanvienxuly($params);

        return $this->render('baocaotheonhanvienxuly', [
            'searchModel' => $searchModel,
            'baocaotheonhanvienxuly' => $baocaotheonhanvienxuly,
            'type' => $type,
        ]);
    }

    public function actionBaocaotheonhanvienbaohong()
    {
        $params = Yii::$app->request->queryParams;
        $type = isset($params['type']) ? $params['type'] : 6;
        $searchModel = new BaohongSearch();
        $baocaotheonhanvienbaohong = $searchModel->baocaotheonhanvienbaohong($params);

        return $this->render('baocaotheonhanvienbaohong', [
            'searchModel' => $searchModel,
            'baocaotheonhanvienbaohong' => $baocaotheonhanvienbaohong,
            'type' => $type,
        ]);
    }

    public function actionBaocaobaohongnhieulan()
    {
        $params = Yii::$app->request->queryParams;
        $type = isset($params['type']) ? $params['type'] : 6;
        $searchModel = new BaohongSearch();
        $baocaobaohongnhieulan = $searchModel->baocaobaohongnhieulan($params);

        return $this->render('baocaobaohongnhieulan', [
            'searchModel' => $searchModel,
            'baocaobaohongnhieulan' => $baocaobaohongnhieulan,
            'type' => $type,
        ]);
    }

    public function actionLichsuxl()
    {
        $searchModel = new BaohongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 0);

        return $this->render('lichsuxl', [
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
        $baohong = $this->findModel($id);
        if ($baohong) {
            return $this->render('view', [
                'model' => $baohong,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập hoặc báo hỏng không tồn tại');

        }

    }

    public function actionXulybaohong($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('dmdv-xlbaohong') || (Yii::$app->user->can('xuly-baohong') && Yii::$app->user->identity->nhanvien->ID_NHANVIEN == $model->nhanvien_xl_id)) {
            if ($model->load(Yii::$app->request->post())) {
                $params = Yii::$app->request->post();
                $model->status = $params['Baohong']['status'] ? $params['Baohong']['status'] : 0;
                $model->nhanvien_xl_id = $params['Baohong']['nhanvien_xl_id'] ? $params['Baohong']['nhanvien_xl_id'] : $model->nhanvien_xl_id;
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
                $donvi = Donvi::findOne($model->donvi_id);
                self::savelog($model, $message, 'capnhatxuly-baohong', $donvi->chatid);
                sendtelegrammessage($donvi->chatid, $message);
                return $this->redirect(['view', 'id' => $id]);
            } else {
                $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['ID_DONVI' => $model->donvi_id])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
                return $this->render('xulybaohong', [
                    'model' => $model,
                    'dsNhanvien' => $dsNhanvien,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập hoặc báo hỏng không tồn tại');
        }
    }

    public function actionPhanhoixuly($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('nhanvien-kd-baohong') && in_array($model->status, [1,3]) && ($model->nhanvien_id == Yii::$app->user->identity->nhanvien->ID_NHANVIEN)){
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
                $donvi = Donvi::findOne($model->donvi_id);
                self::savelog($model, $message, 'phanhoixuly-baohong', $donvi->chatid);
                sendtelegrammessage($donvi->chatid, $message);
                return $this->redirect(['index']);
            } else {
                return $this->render('phanhoixuly', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập hoặc báo hỏng không tồn tại');
        }
    }

    // public function actionNhanxuly($id)
    // {
    //     $model = $this->findModel($id);
    //     if (Yii::$app->user->can('dmdv-xlbaohong') || (Yii::$app->user->can('xuly-baohong'))) {
    //         if (Yii::$app->request->post()) {
    //             $model->nhanvien_xl_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
    //             $model->nv_thaotac_xl = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
    //             $model->save(false);
    //             $message = '<code><b>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . '</b></code>';
    //             $message .= ' NHẬN XỬ LÝ' . " \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD \xF0\x9F\x91\xBD " . PHP_EOL;
    //             self::tinnhanchung($model, $message);
    //             $message .= " \xF0\x9F\x94\x93 \xF0\x9F\x94\x93 " . 'Ghi chú xử lý: <u>' . $model->ghichu . '</u>' . PHP_EOL;
    //             $message .= " \xF0\x9F\x91\x89 \xF0\x9F\x91\x89 \xF0\x9F\x91\x89" . '<a href="' . Url::to(['baohong/view', 'id' => $model->id], true) . '">Chi tiết</a>';
    //             $donvi = Donvi::findOne($model->donvi_id);
    //             self::savelog($model, $message, 'capnhatxuly-baohong', $donvi->chatid);
    //             //sendtelegrammessage($donvi->chatid, $message);
    //             die('ok');
    //             return ['error' => false];
    //         }
    //     } else {
    //         throw new ForbiddenHttpException('Bạn không có quyền truy cập hoặc báo hỏng không tồn tại');
    //     }
    // }

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
                if (!$model->validate()) {
                    Yii::$app->session->setFlash('error', "Lỗi khởi tạo!");
                    $errors = $model->errors;
                    return $this->render('create', [
                    'model' => $model,
                    'errors' => $errors,
                    'dsNhanvien' => $dsNhanvien,
                ]);
                }
                $arrdichvu = $model->dichvu_id;
                $model->dichvu_id = json_encode($arrdichvu);
                $model->nhanvien_id = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->ma_tb = strtolower($model->ma_tb);
                $model->save();
                foreach($arrdichvu as $dichvu) {
                    $dv = new Dichvubaohong();
                    $dv->dichvu_id = $dichvu;
                    $dv->baohong_id = $model->id;
                    $dv->save(false);
                }
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

    public function actionGuilaitinnhan($id, $type)
    {
        $log = ActivitiesLog::find()->where(['baohong_id' => $id, 'activity_type' => $type])->orderBy(['activity_log_id' => SORT_DESC])->one();
        if ($log) {
            sendtelegrammessage($log->chatid, Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . ' GỬI LẠI TIN NHẮN' .  PHP_EOL .  $log->description);
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

    public function actionTestbyaccount()
    {
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $matb = $params['ma_tb'];
            $result = testbyaccount($matb);
            return $result;
        }
    }

    public function actionKiemtrathongtinthuebao()
    {
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $matb = $params['ma_tb'];
            $result = getByAccount($matb);
            die(var_dump((array)$result));
            $error = true;
            $data = [];
            if (is_array($result)) {
                $error = false;
                $data = [
                    'AccountName' => $result[0]->AccountName,
                    'SubName' => $result[0]->SubName,
                    'FrameNo' => $result[0]->FrameNo,
                    'SlotNo' => $result[0]->SlotNo,
                    'PortNo' => $result[0]->PortNo,
                    'OnuIndex' => $result[0]->OnuIndex,
                ];
            }
            return [
                'error' => false,
                'data' => $data,
            ];
        }
    }
}
