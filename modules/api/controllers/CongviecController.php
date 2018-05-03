<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\modules\api\Service;
use app\modules\api\CongViecAPI;
use yii\filters\AccessControl;


/**
 * Default controller for the `api` module
 */
class CongviecController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	public function beforeAction($action)
    {
		if (!parent::beforeAction($action)) {
		  return false;
		}
		if (Service::verifyAccess(Yii::$app->getRequest()->getQueryParam('app_id'),Yii::$app->getRequest()->getQueryParam('app_secret'))) {
		return true;
		} else {
			echo 'Sorry. Your request is not allowed!!!';
			Yii::$app->end();
		}
    }

    public function actionHello($app_id, $app_secret, $token)
    {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	if (Yii::$app->request->post()) {
			return CongViecAPI::createDemo($token, Yii::$app->request->post());
		} else {
    		return false;
		}
    }

    /**
     * API list all tasks of user with status
     * $status = ['Kế hoạch', 'Đang thực hiện', 'Kết thúc' ]
     * @return json
     */    
    public function actionList($app_id, $app_secret, $token, $status='', $dotbd='') {
		Yii::$app->response->format = Response::FORMAT_JSON;
		return CongViecAPI::list($token, $status, $dotbd);
	}
}
