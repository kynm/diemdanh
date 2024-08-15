<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use DateTime;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use app\models\Diemdanhhocsinh;
use app\models\Donvi;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LenlichController extends Controller
{

	public function actionTestemail()
    {
        $email = 'ngainguyendv@gmail.com';
        $title = 'Gửi mail thông báo';
        $body = 'Cộng hòa - xã hội - chủ nghĩa - Việt Nam. <br/> Độc lập - tự  do - Hạnh Phúc';
        sendmail($email, $title, $body);
        return 'GỬI MAIL THÀNH CÔNG';
    }

    public function actionBaocaohoatdonghangngay()
    {
        $dsdonvi = Donvi::find()->where(['is not', 'EMAIL', new \yii\db\Expression('null')])
        //->andWhere(['STATUS' => 2])
        ->all();
        foreach ($dsdonvi as $key => $donvi) {
            $sldiemdanh = $donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->count();
            $tongsohocsinh = Diemdanhhocsinh::find()->where(['in', 'ID_DIEMDANH', ArrayHelper::map($donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->all(), 'ID', 'ID')])->count();
            $slhocsinhnghi = Diemdanhhocsinh::find()->where(['in', 'ID_DIEMDANH', ArrayHelper::map($donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->all(), 'ID', 'ID')])->andWhere(['STATUS' => 0])->count();
            $noidung =  $donvi->TEN_DONVI . '<br/>';
            $noidung .= ' - Số lượng điểm danh:<span style="font-size: 15px">' . $sldiemdanh . '</span> lượt điểm danh<br/>';
            $noidung .= ' - Tổng số học sinh thực hiện điểm danh :<span style="font-size: 15px">' . $tongsohocsinh . '</span> Học sinh<br/>';
            $noidung .= ' - Số lượng nghỉ:<span style="font-size: 15px">' . $slhocsinhnghi . '</span> Học sinh nghỉ<br/>';
            $noidung .= 'Vui lòng <a href="https://diemdanh.online">Truy cập hệ thống</a> điểm danh online EASYCHECK để theo dõi chi tiết!';
            sendmail($donvi->EMAIL, 'DỮ LIỆU ĐIỂM DANH HÀNG NGÀY', $noidung);
        }
        return 'GỬI MAIL THÀNH CÔNG';
    }
}
