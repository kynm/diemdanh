<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\modules\api\Service;
use app\models\User;
use yii\filters\AccessControl;


class SystemController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['POST']
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

    /**
     * Login action.
     *
     * @return Response|false
     */
    public function actionLogin($username ='', $password='')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByUsername($username);
        if ($user->validatePassword($password)) {
        	return $user;
        }
        
        return false;
    }

    /**
     * Logout action.
     *
     * @return response
     */
    public function actionLogout()
    {
    	Yii::$app->response->format = Response::FORMAT_JSON;
        $info = ['user' => null];
        return $info;
    }
}