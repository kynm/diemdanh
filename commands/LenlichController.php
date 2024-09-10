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
        // ->andWhere(['STATUS' => 2])
        ->orderBy('ID_DONVI')
        ->all();
        foreach ($dsdonvi as $key => $donvi) {
            if (trim($donvi->EMAIL)) {
                $sldiemdanh = $donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->count();
                $tongsohocsinh = Diemdanhhocsinh::find()->where(['in', 'ID_DIEMDANH', ArrayHelper::map($donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->all(), 'ID', 'ID')])->count();
                $slhocsinhnghi = Diemdanhhocsinh::find()->where(['in', 'ID_DIEMDANH', ArrayHelper::map($donvi->getDsdiemdanh()->andWhere(['date(created_at)' => date('Y-m-d')])->all(), 'ID', 'ID')])->andWhere(['STATUS' => 0])->count();
                $noidung =  $donvi->TEN_DONVI . '<br/>';
                $noidung .= ' - Số lượng điểm danh:<span style="font-size: 15px">' . $sldiemdanh . '</span> lượt điểm danh<br/>';
                $noidung .= ' - Tổng số học sinh thực hiện điểm danh :<span style="font-size: 15px">' . $tongsohocsinh . '</span> Học sinh<br/>';
                $noidung .= ' - Số lượng nghỉ:<span style="font-size: 15px">' . $slhocsinhnghi . '</span> Học sinh nghỉ<br/>';
                $noidung .= 'Vui lòng <a href="https://diemdanh.online">Truy cập hệ thống</a> điểm danh online EASYCHECK để theo dõi chi tiết!';
                $sql = "SELECT COUNT(1) SOLUONG FROM quanlyhocphi a, chitiethocphi b WHERE a.ID = b.ID_QUANLYHOCPHI AND b.STATUS = 0 and a.ID_DONVI = :ID_DONVI";
                $slhocphichuathu = Yii::$app->db->createCommand($sql)->bindValues(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->queryAll();
                $sql = "SELECT COUNT(1) SOLUONG FROM quanlyhocphithutruoc a WHERE a.STATUS = 1 and a.ID_DONVI = :ID_DONVI";
                $slhocphithutruocchuathu = Yii::$app->db->createCommand($sql)->bindValues(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->queryAll();
                if ($slhocphichuathu) {
                    $noidung .= ' - HỌC SINH CHƯA THU HỌC PHÍ HÀNG THÁNG :<span style="font-size: 15px">' . $slhocphichuathu[0]['SOLUONG'] . '</span> Học sinh<br/>';
                }
                if ($slhocphithutruocchuathu) {
                    $noidung .= ' - HỌC SINH CHƯA THU HỌC PHÍ (THU TRƯỚC) :<span style="font-size: 15px">' . $slhocphithutruocchuathu[0]['SOLUONG'] . '</span> Học sinh<br/>';
                }
                // echo PHP_EOL;
                // echo $donvi->TEN_DONVI . '---' . $donvi->EMAIL;
                // $result = sendmail('ngainguyendv@gmail.com', 'DỮ LIỆU ĐIỂM DANH HÀNG NGÀY', $noidung);
                // (var_dump($result));
                sendmail($donvi->EMAIL, 'DỮ LIỆU ĐIỂM DANH HÀNG NGÀY', $noidung);
                sleep(5);
            }
        }
        return 'GỬI MAIL THÀNH CÔNG';
    }
}
