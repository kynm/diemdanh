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
            if (Yii::$app->user->can('diemdanhlophoc')) {
                $dslop = Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->andWhere(['ID_NHANVIEN_DIEMDANH' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->all();
                return $this->render('diemdanhlophoc', [
                    'dslop' => $dslop,
                ]);
            }
            return $this->render('index', [
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
