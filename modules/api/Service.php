<?php
namespace app\modules\api;

use Yii;
use yii\base\Model;

class Service extends Model
{
	/**
	 * Function to verify app_id and app_secret
	 * before access the action
	 */
    public static function verifyAccess($app_id,$app_secret) {
      	if ($app_id == Yii::$app->params['app_id'] && $app_secret == Yii::$app->params['app_secret']) {
            // Yii::$app->params['site']['id']=SiteHelper::SITE_SP;
            return true;
        } else {
          return false;
        }
    }


}