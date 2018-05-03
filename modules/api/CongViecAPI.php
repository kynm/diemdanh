<?php 
namespace app\modules\api;
 
use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Noidungcongviec;


class CongViecAPI extends Model
{
    public static function list($token, $status, $dotbd) {
		$user = User::findIdentityByAccessToken($token);
		if (!$user) {
			return false;
		}
		$query = Noidungcongviec::find()->joinWith('dOTBD');

		if ($status !== '') {
			$query->andWhere(['dotbaoduong.TRANGTHAI' => $status]);
		}

		if ($dotbd !== '') {
			$query->andWhere(['noidungcongviec.ID_DOTBD' => $dotbd]);
		} else {
			$query->andWhere(['ID_NHANVIEN'=> $user->nhanvien->ID_NHANVIEN ]);
		}

		$tasks = $query->all();
		
		return $tasks;
    }


    public static function createDemo($token, $data) {
		$model = new Noidungcongviec;
		$model->load($data);
		$model->save(false);
		return $model;
    }
}