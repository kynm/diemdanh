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
        return json_encode($searchModel->danhsachthietbi(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function actionPhanbospliter()
    {
        return $this->render('dsspliter', [
        ]);
    }

    public function actionLaydsspliter()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new IOCSearch();
        return json_encode($searchModel->danhsachspliter(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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
}
