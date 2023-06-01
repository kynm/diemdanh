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
use app\models\User;
use app\models\Nhanvien;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class XulyController extends Controller
{
    /*
     * Copy email
     * Remove @vnpt.vn after username at user and nhanvien
     */
    public function actionEditEmail()
    {
        $listNhanvien = Nhanvien::find()->all();
        
    }

    public function actionChuagiahan()
    {
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-d', strtotime("+10 day"));
        $sql = "SELECT b.TEN_NHANVIEN, COUNT(1) SO_LUONG FROM khachhanggiahan a, nhanvien b WHERE a.nhanvien_id =b.ID_NHANVIEN and a.ketqua IN (0,1,2,3,4) AND a.NGAY_HH <= '" . $endDate . "' GROUP BY b.TEN_NHANVIEN;";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        $message = 'SỐ LƯỢNG THUÊ BAO CHƯA GIA TRONG 10 NGÀY TỚI: ' . PHP_EOL;
        foreach ($result as $key => $value) {
            $message .= $value['TEN_NHANVIEN'] . '      :     ' . $value['SO_LUONG'] . '   thuê bao' . PHP_EOL;
        }
        $message .= '<u> <a href="https://hotro.vnpthanam.vn/giahandichvu/dashboard">Chi tiết</a></u>' . PHP_EOL;
        Yii::$app->telegram->sendMessage([
            'chat_id' => '-955693011',
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
