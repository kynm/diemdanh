<?php

namespace app\controllers;

use Yii;
use app\models\Noidungcongviec;
use yii\web\Controller;
use yii\filters\AccessControl;

class ApiController extends Controller
{
	public function behaviors()
	{
	    $behaviors = parent::behaviors();

	    // remove authentication filter
	    $auth = $behaviors['authenticator'];
	    unset($behaviors['authenticator']);
	    
	    // add CORS filter
	    $behaviors['corsFilter'] = [
	        'class' => \yii\filters\Cors::className(),
	    ];
	    
	    // re-add authentication filter
	    $behaviors['authenticator'] = $auth;
	    // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
	    $behaviors['authenticator']['except'] = ['options'];

	    return $behaviors;
	}
	
    /**
     * API lấy danh sách các công việc
     * *đang thực hiện*
     * của người dùng
     * @return json
     */

    public function actionGetCongViec()
    {
        
        $inprogressProvider = Noidungcongviec::find()->joinWith('dOTBD')->where(['ID_NHANVIEN'=> Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => 'Đang thực hiện' ])->all();
        var_dump($inprogressProvider);
        die;
    }
}