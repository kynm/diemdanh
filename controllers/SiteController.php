<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\AuthItemChild;
use app\models\Khachhanggiahan;
use app\models\Donvi;
use app\models\Nhanvien;
use app\models\Dichvu;
use app\models\KhachhanggiahanSearch;
use moonland\phpexcel\Excel;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        } else {
            $dsketquagiahanca = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN,SUM(CASE WHEN MONTH(b.NGAY_HH) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND b.DICHVU_ID = 10  group by c.TEN_NHANVIEN')->queryAll();
            $dsketquagiahanivan = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN,SUM(CASE WHEN MONTH(b.NGAY_HH) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS KEHOACHTHANG, SUM(CASE WHEN b.ketqua = 1 OR b.ketqua = 3 OR b.ketqua = 5 OR b.ketqua = 6 OR b.ketqua = 7 OR b.ketqua = 8 THEN 1 ELSE 0 END) AS DALH ,  SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAGIAHAN ,  count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN AND b.DICHVU_ID = 15  group by c.TEN_NHANVIEN')->queryAll();

            $searchModel = new KhachhanggiahanSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->searchtrangchu($params);
            $dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
            $dsNhanvien = ArrayHelper::map(Nhanvien::find()->where(['in', 'ID_DAI', [25280]])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dsketquagiahanca' => $dsketquagiahanca,
                'dsketquagiahanivan' => $dsketquagiahanivan,
                'dsDichvu' => $dsDichvu,
                'dsNhanvien' => $dsNhanvien,
            ]);
        }
        // return $this->render('index');
    }

    public function actionAssignRule()
    {
        $lv2_items = AuthItem::find()->where(['type' => 2])->all();
        foreach ($lv2_items as $item) {
            $exists = AuthItemChild::find()->where(['parent' => 'do-admin', 'child' => $item->name])->exists();
            if (!$exists) {
                $assign = new AuthItemChild;
                $assign->parent = 'do-admin';
                $assign->child = $item->name;
                $assign->save();
            }
        }
    }

    public function actionBaocaothue()
    {

        $this->layout = 'layoutBaocaothue';
        $dsketquachuyendoitheocongty = Yii::$app->db->createCommand('SELECT c.TEN_NHANVIEN, SUM(CASE WHEN b.ketqua = 1 THEN 1 ELSE 0 END) AS DALH , SUM(CASE WHEN b.ketqua = 2 THEN 1 ELSE 0 END) AS DATHEMZALO , SUM(CASE WHEN b.ketqua = 3 THEN 1 ELSE 0 END) AS TVNV , SUM(CASE WHEN b.ketqua = 4 THEN 1 ELSE 0 END) AS GUIDK01 , SUM(CASE WHEN b.ketqua = 5 THEN 1 ELSE 0 END) AS DAPHHD , SUM(CASE WHEN b.ketqua = 6 THEN 1 ELSE 0 END) AS HDNVKHAC , SUM(CASE WHEN b.ketqua = 7 THEN 1 ELSE 0 END) AS HUYDV, SUM(CASE WHEN b.ketqua = 8 THEN 1 ELSE 0 END) AS GIAITHE, SUM(CASE WHEN b.ketqua = 9 THEN 1 ELSE 0 END) AS DADUNGDNK, count(*) TONG FROM khachhanggiahan b, nhanvien c WHERE b.nhanvien_id = c.ID_NHANVIEN  group by c.TEN_NHANVIEN')->queryAll();

        $searchModel = new KhachhanggiahanSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchBaocaothue($params);
        return $this->render('baocaothue', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dsketquachuyendoitheocongty' => $dsketquachuyendoitheocongty,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    // public function beforeAction($action)
    // {
    //     $user = User::find()->where(['username' => Yii::$app->user->identity->username])->one();
    //     $user->updated_at = time();
    //     $user->save();
    //     if (!parent::beforeAction($action)) {
    //         return false;
    //     }

    //     return true; 
    // }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTinnhandieuhanh()
    {
        if (Yii::$app->user->can('create-tinnhandieuhanh')) {
            if (Yii::$app->request->post()) {
                $params = Yii::$app->request->post();
                $noidung = $params['noidung'];
                $dsdonvi = $params['donvi_id'];
                if ($noidung) {
                    foreach($dsdonvi as $id)
                    {
                        if ($params['noidung']) {
                            $donvi = Donvi::find()->where(['ID_DONVI' => $id])->one();
                            $message = '<code>' . Yii::$app->user->identity->nhanvien->TEN_NHANVIEN . ' GỬI TIN NHẮN </code>'. PHP_EOL;
                            $message .= $params['noidung'];
                            if ($donvi && $donvi->telegram_id) {
                                sendtelegrammessage($donvi->chatid, $message);
                            }
                        }
                    }
                }
                Yii::$app->session->setFlash('success', "Đã gửi lại tin nhắn telegram thành công!");
                return $this->redirect(['index']);
            } else {
                return $this->render('tinnhandieuhanh', [
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionThuthuat()
    {
        return $this->render('thuthuat');
    }
}
