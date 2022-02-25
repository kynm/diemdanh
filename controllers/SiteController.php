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
use app\models\Baoduongtong;
use app\models\Donvi;
use app\models\Nhanvien;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Thietbitram;
use app\models\Tramvt;
use moonland\phpexcel\Excel;

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
            $dsbaohongdaxl = Yii::$app->db->createCommand('SELECT b.TEN_DONVI, COUNT(*) SO_LUONG FROM baohong a, donvi b where a.donvi_id = b.ID_DONVI and a.status in (1,3,4,5) GROUP BY b.TEN_DONVI')->queryAll();
            $dsbaohongchuaxl = Yii::$app->db->createCommand('SELECT b.TEN_DONVI, COUNT(*) SO_LUONG FROM baohong a, donvi b where a.donvi_id = b.ID_DONVI and a.status in (0,2) GROUP BY b.TEN_DONVI')->queryAll();
            $dsbaohongtheodichvu= Yii::$app->db->createCommand('SELECT b.TEN_DONVI , SUM(CASE WHEN c.dichvu_id = 1 THEN 1 ELSE 0 END) AS FIBER , SUM(CASE WHEN c.dichvu_id = 2 THEN 1 ELSE 0 END) AS MYTV , SUM(CASE WHEN c.dichvu_id = 2 THEN 1 ELSE 0 END) AS DTCD , SUM(CASE WHEN c.dichvu_id = 2 THEN 1 ELSE 0 END) AS DIDONG FROM baohong a, donvi b,dichvu_baohong c, dichvu d where a.donvi_id = b.ID_DONVI and a.id = c.baohong_id and c.dichvu_id = d.id GROUP BY b.TEN_DONVI')->queryAll();
            // die(var_dump($dsbaohongdaxl));
            return $this->render('index'
                ,[
                'dsbaohongdaxl' => $dsbaohongdaxl,
                'dsbaohongchuaxl' => $dsbaohongchuaxl,
                'dsbaohongtheodichvu' => $dsbaohongtheodichvu,
                ]
            ); 
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

    public function actionImport()
    {
        ini_set('max_execution_time', 0);
        $file = 'data/ImportThietbi.xlsx';
        $data = Excel::import($file);
        $count = 1;
        $imported = 0;
        foreach ($data as $record) {
            $count++;
            if ( Nhomtbi::find()->where(['MA_NHOM' => $record['MA_NHOM']])->exists() ) {
                $nhomtbi = Nhomtbi::find()->where(['MA_NHOM' => $record['MA_NHOM']])->one();
            } else {
                $nhomtbi = new Nhomtbi;
                $nhomtbi->MA_NHOM = $record['MA_NHOM'];
                $nhomtbi->TEN_NHOM = $record['TEN_NHOM'];
                $nhomtbi->save(false);
            }
            if ( Thietbi::find()->where(['MA_THIETBI' => $record['MA_THIETBI']])->exists() ) {
                $thietbi = Thietbi::find()->where(['MA_THIETBI' => $record['MA_THIETBI']])->one();
            } else {
                $thietbi = new Thietbi;
                $thietbi->MA_THIETBI = $record['MA_THIETBI'];
                $thietbi->TEN_THIETBI = $record['TEN_THIETBI'];
                $thietbi->ID_NHOM = $nhomtbi->ID_NHOM;
                $thietbi->HANGSX = $record['HANGSX'];
                $thietbi->THONGSOKT = $record['THONGSOKT'];
                $thietbi->PHUKIEN = $record['PHUKIEN'];
                $thietbi->save(false);
            }
            if (!Tramvt::find()->where(['MA_TRAM' => $record['MA_TRAM']])->exists()) {
                echo "Mã trạm tại dòng $count không đúng. Yêu cầu xem lại!<br>";
                continue;
            } else {
                $tram = Tramvt::find()->where(['MA_TRAM' => $record['MA_TRAM']])->one();
            }
            if ( Thietbitram::find()->where(['SERIAL_MAC' => $record['SERIAL_MAC']])->exists() ) {
                echo "Thiết bị tại dòng $count bị trùng serial / mac.<br>";
                continue;
            } else {
                $thietbitram = new Thietbitram;
                $thietbitram->ID_LOAITB = $thietbi->ID_THIETBI;
                $thietbitram->ID_TRAM = $record['TEN_THIETBI'];
                $thietbitram->SERIAL_MAC = $record['SERIAL_MAC'];
                $thietbitram->NGAYSX = $record['NGAYSX'];
                $thietbitram->NGAYSD = $record['NGAYSD'];
                $thietbitram->save(false);
            }
        }
    }

    public function actionBaoduong()
    {
        $this->layout = 'baoduongLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->render('baoduongcanhan', [
            ]);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
    }

    public function actionIoc()
    {
        $this->layout = 'iocLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->render('chucnangioc', [
            ]);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
    }
}
