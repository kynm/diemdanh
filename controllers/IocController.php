<?php
namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use app\models\ThietbiIOC;
use app\models\IOCSearch;
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
        // echo "<pre>";
        // die(var_dump($dsthietbi));
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

    public function actionPhanbothuebao()
    {
        return $this->render('dsthuebao', [
        ]);
    }

    public function actionLaydsthuebao()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        return json_encode($searchModel->danhsachthuebao(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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
