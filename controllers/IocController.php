<?php
namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use app\models\ThietbiIOC;
use app\models\IOCSearch;
use app\models\IOCThuebaoSearch;
use app\models\Images;
use app\models\AuthorizationCodes;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\MultipleUploadForm;
use yii\helpers\ArrayHelper;

class IocController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $this->layout = 'iocLayout';
        return $behaviors + [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public $imageFile;

    public function actionPhanbothietbi()
    {
        return $this->render('dsthietbi', [
        ]);
    }

    public function actionLaydsthietbi()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        return json_encode($searchModel->danhsachthietbi($params), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function actionPhanbospliter()
    {
        $dsthietbi =  ArrayHelper::map(ThietbiIOC::find()->asArray()->all(), 'ID_THIETBI', 'SYSTEM');
        return $this->render('dsspliter', [
            'dsthietbi' => $dsthietbi,
        ]);
    }

    public function actionLaydsspliter()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        return json_encode($searchModel->danhsachspliter($params), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function actionLaythongtinspliter()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        return json_encode($searchModel->laythongtinspliter($params), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function actionPhanbothuebao()
    {
        $dsthietbi =  ArrayHelper::map(ThietbiIOC::find()->asArray()->all(), 'ID_THIETBI', 'SYSTEM');
        return $this->render('dsthuebao', [
            'dsthietbi' => $dsthietbi,
        ]);
    }

    public function actionBaocaothuebao()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        $dsspliter = [];
        foreach ($searchModel->danhsachspliter($params) as $key => $value) {
           $dsspliter[$value['KETCUOI_ID']] = $value['TEN_KC'];
        }
        // ;
        // echo "<pre>";
        // die(var_dump($dsspliter));
        $dsthietbi =  ArrayHelper::map(ThietbiIOC::find()->asArray()->all(), 'ID_THIETBI', 'SYSTEM');
        $searchModel = new IOCThuebaoSearch();
        $dataProvider = $searchModel->search($params);
        // echo "<pre>";
        // die(var_dump($dsthuebao));
        return $this->render('baocaothuebao', [
            'dsthietbi' => $dsthietbi,
            'dsspliter' => $dsspliter,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    public function actionUpdatequangduongthuebao()
    {
        $dsthietbi =  ArrayHelper::map(ThietbiIOC::find()->asArray()->all(), 'ID_THIETBI', 'SYSTEM');
        $searchModel = new IOCSearch();
        $params['KETCUOI_ID'] = null;
        $dsthuebao = $searchModel->baocaodanhsachthuebao($params);
        foreach ($dsthuebao as $key => $value) {
            $dsthuebao[$key]['KHOANG_CACH'] = haversineGreatCircleDistance($value['VIDO_SPL'],$value['KINHDO_SPL'],$value['VIDO_TB'],$value['KINHDO_TB']);
            $sqltonghop = "update ioc_thuebao set KHOANG_CACH = " . $dsthuebao[$key]['KHOANG_CACH'] . " WHERE ma_tb = '" . $dsthuebao[$key]['ma_tb'] . "'";
            Yii::$app->db->createCommand($sqltonghop)->execute();
        }
        echo "<pre>";
        die(var_dump($dsthuebao));
        return $this->render('baocaothuebao', [
            'dsthietbi' => $dsthietbi,
        ]);
    }

    public function actionLaydsthuebao()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        $spt = $searchModel->laythongtinspliter($params);
        $dsthuebao = $searchModel->danhsachthuebao($params);
        foreach ($dsthuebao as $key => $value) {
            $dsthuebao[$key]['KHOANG_CACH'] = haversineGreatCircleDistance($spt[0]['VIDO'],$spt[0]['KINHDO'],$value['VIDO'],$value['KINHDO']);
        }

        return json_encode($dsthuebao, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function actionBaocaothiphanthuebao()
    {
        $searchModel = new IOCSearch();
        $thiphan = $searchModel->thiphanthuebao();
        // $tongthuebao = $searchModel->tongsothuebao();
        return $this->render('thiphanthuebao', [
            'thiphan' => $thiphan,
            'tongthuebao' => 18618,
        ]);
    }
}
