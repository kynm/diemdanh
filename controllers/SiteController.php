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
use app\models\Hocsinh;
use app\models\Lophoc;
use app\models\Donhang;
use app\models\Tintuc;
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

    // public function beforeAction($action)
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         $donvi = Yii::$app->user->identity->nhanvien->iDDONVI;
    //         $date1=date_create($donvi->NGAY_KT);
    //         $date2= date_create(date('Y-m-d'));
    //         if ($date2 < $date1) {
    //             return $this->redirect(['login']);
    //         }
    //     }

    //     return true; // or false to not run the action
    // }

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
            if (Yii::$app->user->can('Administrator')) {
                $sldonvi = Donvi::find()->count();
                $sltk = Nhanvien::find()->count();
                $sllh = Lophoc::find()->count();
                $slhs = Hocsinh::find()->count();
                $sldh = Donhang::find()->count();
                return $this->render('index', [
                    'sldonvi' => $sldonvi,
                    'sltk' => $sltk,
                    'sllh' => $sllh,
                    'slhs' => $slhs,
                    'sldh' => $sldh,
            ]);
            }
            if (Yii::$app->user->can('quanlytruonghoc') || Yii::$app->user->can('quanlyhocphi')) {
                $solop = Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->andWhere(['STATUS' => 1])->count();
                $sonhanvien = Yii::$app->user->identity->nhanvien->iDDONVI->getNhanviens()->andWhere(['not in', 'CHUC_VU', [5]])->count();
                $tongsohocvien = Yii::$app->user->identity->nhanvien->iDDONVI->getHocsinh()->andWhere(['STATUS' => 1])->count();
                $sql = "SELECT b.TEN_LOP, b.ID_LOP
                    ,COUNT(1) SOHOCSINH
                    , SUM(case when d.STATUS = 1 then 1 ELSE 0 END) SOLUONGDIHOC
                    ,SUM(case when d.STATUS = 0 then 1 ELSE 0 END) SOLUONGNGHI
                    ,GROUP_CONCAT(CASE WHEN d.`STATUS` = 0 then e.HO_TEN ELSE NULL END) HOCSINHNGHI
                    FROM donvi a, lophoc b, quanlydiemdanh c,diemdanhhocsinh d, hocsinh e
                    WHERE a.ID_DONVI = b.ID_DONVI AND b.ID_LOP = c.ID_LOP AND c.ID = d.ID_DIEMDANH AND d.ID_HOCSINH = e.ID
                        AND a.ID_DONVI = :ID_DONVI
                        AND c.NGAY_DIEMDANH = :NGAY_DIEMDANH
                        GROUP BY b.TEN_LOP, b.ID_LOP  ORDER BY b.ID_LOP";
                $dulieungay = Yii::$app->db->createCommand($sql)->bindValues(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI, ':NGAY_DIEMDANH' => date('Y-m-d')])->queryAll();
                $sql = "SELECT COUNT(1) SOLUONG FROM quanlyhocphi a, chitiethocphi b WHERE a.ID = b.ID_QUANLYHOCPHI AND b.STATUS = 0 and a.ID_DONVI = :ID_DONVI";
                $slhocphichuathu = Yii::$app->db->createCommand($sql)->bindValues(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->queryAll();
                $sql = "SELECT COUNT(1) SOLUONG FROM quanlyhocphithutruoc a WHERE a.STATUS = 1 and a.ID_DONVI = :ID_DONVI";
                $slhocphithutruocchuathu = Yii::$app->db->createCommand($sql)->bindValues(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->queryAll();
                // Học sinh cần đóng học phí theo buổi
                $slhocsinhhethocphitheobuoi = 0;
                if (Yii::$app->user->identity->nhanvien->iDDONVI->HP_T) {
                    $sql = 'SELECT COUNT(1) SOLUONG FROM
                    (SELECT b.ID,a.TEN_LOP, b.HO_TEN, sum(case when c.`STATUS` = 1 then 1 ELSE 0 END) SOLUONG_DAHOC FROM lophoc a, hocsinh b, diemdanhhocsinh c WHERE a.ID_LOP = b.ID_LOP AND b.ID = c.ID_HOCSINH AND a.ID_DONVI = :ID_DONVI and a.STATUS = 1 and b.NGAY_KT IS NULL GROUP BY b.ID,a.TEN_LOP, b.HO_TEN) bh,
                    (SELECT b.ID, sum(case when c.`STATUS` = 2 then c.SO_BH ELSE 0 END) SOLUONG_DADONGTIEN FROM lophoc a, hocsinh b, quanlyhocphithutruoc c WHERE a.ID_LOP = b.ID_LOP AND b.ID = c.ID_HOCSINH AND a.ID_DONVI = :ID_DONVI and a.STATUS = 1 and b.NGAY_KT IS NULL GROUP BY b.ID) bdt
                    WHERE bh.ID = bdt.ID AND bdt.SOLUONG_DADONGTIEN - bh.SOLUONG_DAHOC < 1';
                    $slhocsinhhethocphitheobuoi = Yii::$app->db->createCommand($sql)->bindValues(
                    [
                        ':ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                    ])->queryAll();
                }
                return $this->render('quanlytruonghoc', [
                    'solop' => $solop,
                    'tongsohocvien' => $tongsohocvien,
                    'dulieungay' => $dulieungay,
                    'sonhanvien' => $sonhanvien,
                    'slhocphichuathu' => $slhocphichuathu,
                    'slhocphithutruocchuathu' => $slhocphithutruocchuathu,
                    'slhocsinhhethocphitheobuoi' => $slhocsinhhethocphitheobuoi,
                ]);
            }

            if (Yii::$app->user->can('diemdanhlophoc')) {
                $idlop = ArrayHelper::map(Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->andWhere(['STATUS' => 1])->andWhere(['ID_NHANVIEN_DIEMDANH' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->all(), 'ID_LOP', 'ID_LOP');
                $idlop = array_merge($idlop, explode(',', Yii::$app->user->identity->nhanvien->ds_lop));
                if (Yii::$app->user->can('diemdanhtoantrungtam')) {
                    $idlop = ArrayHelper::map(Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->andWhere(['STATUS' => 1])->all(), 'ID_LOP', 'ID_LOP');
                }

                $dslop = Lophoc::find()->where(['in', 'ID_LOP', $idlop])->all();
                return $this->render('diemdanhlophoc', [
                    'dslop' => $dslop,
                ]);
            }


            if (Yii::$app->user->can('phuhuynhhocsinh')) {
                $dstintuc = Tintuc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['STATUS' => 1])->all();
                return $this->render('phuhuynhhocsinh', [
                    'dstintuc' => $dstintuc,
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

    public function actionCongcuhotro()
    {
        return $this->render('congcuhotro');
    }


    public function actionTinhngay()
    {
        $params = Yii::$app->request->queryParams;
        $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date('Y-m-d');
        $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
        $date1=date_create($params['TU_NGAY']);
        $date2=date_create($params['DEN_NGAY']);
        if ($date1 < $date2) {
        echo "Ngày 1 đến trước ngày 2";
        } elseif ($date1 > $date2) {
            echo "Ngày 1 đến sau ngày 2";
        } else {
            echo "Ngày 1 và ngày 2 bằng nhau";
        }
        $diffs = $date1->diff($date2)->format("%a");
        $result = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        ];
        for ($i=0; $i <= $diffs; $i++) {
            $date = date('Y-m-d', strtotime($params['TU_NGAY'] . ' + ' . $i . ' days'));
            $thu = date('w', strtotime($date));
            switch ($thu) {
                case 0:
                    $result[0] ++;
                    break;
                case 1:
                    $result[1] ++;
                    break;
                case 2:
                    $result[2] ++;
                    break;
                case 3:
                    $result[3] ++;
                    break;
                case 4:
                    $result[4] ++;
                    break;
                case 5:
                    $result[5] ++;
                    break;
                case 6:
                    $result[6] ++;
                    break;
                
                default:
                    break;
            }
        }
        
        return $this->render('tinhngay', [
            'params' => $params,
            'result' => $result,
        ]);
    }
}
