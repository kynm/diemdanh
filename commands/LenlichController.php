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
use app\models\Nhomtbi;
use app\models\Thietbitram;
use app\models\Baoduongtong;
use app\models\Dotbaoduong;
use app\models\Tramvt;
use app\models\Nhanvien;
use app\models\LogKiemtranhatram;
use app\models\LogSms;

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
    /*
     * Action tao bao duong tong KTNT 25 hang thang.
     * php yii ;
     */
    public function actionBdtKtnt()
    {
        $model = new Baoduongtong;
        $model->MA_BDT = "KTNT_T".date('m-Y', strtotime("next month"));
        $model->TRANGTHAI = 'kehoach';
        $model->ID_NHANVIEN = 227;
        $model->MO_TA = "Kiểm tra vệ sinh nhà trạm";
        $model->TYPE = 2;
        $model->save(false);
        echo "Done!";
    }
    /**
     * Action nay duoc crontab vao ngay 25 hang thang.
     * Tao cac cong viec dinh ky trong thang tiep theo.
     */
    public function actionTaobaoduongdinhky()
    {
    	$bdt = new Baoduongtong;
        $bdt->MA_BDT = "BDDK_T".date('m-Y', strtotime('next month'));
        $bdt->TRANGTHAI = 'kehoach';
        $bdt->ID_NHANVIEN = 227;
        $bdt->MO_TA = "Bảo dưỡng định kỳ";
        $bdt->TYPE = 1;
        $bdt->save(false);
        $listTram = Tramvt::find()->all();
        foreach ($listTram as $tram) {
            $dbd = new Dotbaoduong;
            $dbd->MA_DOTBD = $bdt->MA_BDT ."-". $tram->ID_TRAM;
            $dbd->ID_TRAM = $tram->ID_TRAM;
            $dbd->ID_BDT = $bdt->ID_BDT;
            $dbd->TRANGTHAI = 'kehoach';
            $dbd->NGAY_DUKIEN = date('Y-m-d', strtotime('first day of next month'));
            $dbd->NGAY_BD = $dbd->NGAY_DUKIEN;
            $dbd->NGAY_KT_DUKIEN = date('Y-m-d', strtotime('last day of next month'));
            $dbd->ID_NHANVIEN = $tram->ID_NHANVIEN;
            $dbd->save(false);
            $listThietbitram = Thietbitram::findAll(['ID_TRAM' => $tram->ID_TRAM]);
            foreach ($listThietbitram as $thietbitram) {
                $thietbitram->congviecdinhky($dbd->NGAY_DUKIEN, $dbd->ID_DOTBD);
            }
        }
        echo "Success!";
    }

    /*
     * Action nay duoc chay hang ngay vao 7:00 PM, 
     * kiem tra ngay kiem tra nha tram
     */
    public function actionTaokiemtranhatram()
    {
        $listTram = Tramvt::find()->all();
        $bdt = Baoduongtong::findOne(['MA_BDT' => 'KTNT_T'.date('m-Y', strtotime("next month"))]);
        // $ngaybd = date('Y-m-d', strtotime("tomorrow"));
        foreach ($listTram as $tram) {
            $tram->taodotktnt($bdt->ID_BDT);
            // $lastCheck = new DateTime($tram->NGAY_KTNT);
            // $tomorrow = new DateTime(date('Y-m-d', strtotime("tomorrow")));
            // $diff = $tomorrow->diff($lastCheck);
            
            // switch ($tram->LOAITRAM) {
            //     case '0':
            //         if ($diff->days == 1) {
            //             $tram->taodotktnt($bdt->ID_BDT, $ngaybd);
            //         }
            //         break;
            //     case '1':
            //         if ($diff->days == 7) {
            //             $tram->taodotktnt($bdt->ID_BDT, $ngaybd);
            //         }
            //         break;
            //     case '2':
            //         if ($diff->days == 14) {
            //             $tram->taodotktnt($bdt->ID_BDT, $ngaybd);
            //         }
            //         break;
            //     case '3':
            //         if ($diff->days == 21) {
            //             $tram->taodotktnt($bdt->ID_BDT, $ngaybd);
            //         } 
            //         break;
            // }
        }
        echo "Done!";
    }
    public function actionTaokiemtranhatram2()
    {
        $listTram = Tramvt::find()->all();
        $bdt = Baoduongtong::findOne(['MA_BDT' => 'KTNT_T'.date('m-Y')]);
        foreach ($listTram as $tram) {
            $tram->taodotktnt($bdt->ID_BDT);
        }
        echo "Done!";
    }

    /*
     * Action nay duoc chay vao ngay 1 hang thang. 
     * Thuc hien cac dot bao duong dinh ky. 
     */
    public function actionThuchienbaoduong()
    {
        $ktvsnt = Baoduongtong::findOne(['MA_BDT' => "KTVSNT_T".date('m-Y')]);
        $ktvsnt->TRANGTHAI = 'dangthuchien';
        $ktvsnt->save();
        echo "Success";
    }

    /*
     * Action nay duoc chay vao ngay cuoi cung cua thang. 
     * Ket thuc cac dot bao duong dinh ky. 
     */
    public function actionKetthucbaoduongBAK()
    {
        $bddk = Baoduongtong::findOne(['MA_BDT' => "BDDK_T".date('m-Y')]);
        $bddk->TRANGTHAI = 'ketthuc';
        $bddk->save();
        Yii::$app->db->createCommand('
            UPDATE `dotbaoduong`
                SET TRANGTHAI = "ketthuc"
                WHERE ID_BDT = '.$bddk->ID_BDT.'
        ')->execute();
        $ktvsnt = Baoduongtong::findOne(['MA_BDT' => "KTVSNT_T".date('m-Y')]);
        $ktvsnt->TRANGTHAI = 'ketthuc';
        $ktvsnt->save();
        // Yii::$app->db->createCommand('
        //     UPDATE `dotbaoduong`
        //         SET TRANGTHAI = "ketthuc"
        //         WHERE ID_BDT = '.$ktvsnt->ID_BDT.'
        // ')->execute();
        echo "Success";
    }

    /*
     * Action nay duoc chay vao ngay dau tien cua thang
     * thay cho action phia tren do windows server 2003 
     * khong chon duoc last date
     */
    public function actionKetthucbaoduong()
    {
        $bddk = Baoduongtong::findOne(['MA_BDT' => "BDDK_T".date('m-Y', strtotime("yesterday"))]);
        $bddk->TRANGTHAI = 'ketthuc';
        $bddk->save();

        $ktvsnt = Baoduongtong::findOne(['MA_BDT' => "KTVSNT_T".date('m-Y', strtotime("yesterday"))]);
        $ktvsnt->TRANGTHAI = 'ketthuc';
        $ktvsnt->save();

        $listDbd = Dotbaoduong::find()
            ->where(['ID_BDT' => $bddk->ID_BDT])
            ->orWhere(['ID_BDT' => $ktvsnt->ID_BDT])
            ->all();
        foreach ($listDbd as $dotbd) {
            
        }
        echo "Success";
    }

    /*
     * Action nay duoc chay 7h toi hang ngay. 
     * check viec Kiem tra nha tram theo loai tram. 
     */
    public function actionCheckktnt()
    {
        $listTram = Tramvt::find()->all();
        $noti_array = [];
        $warning_array = [];
        foreach ($listTram as $tram) {
            $lastCheck = new DateTime($tram->NGAY_KTNT);
            $today = new DateTime(date('Y-m-d', strtotime("tomorrow")));
            $diff = $today->diff($lastCheck);
            
            
            switch ($tram->LOAITRAM) {
                case '0':
                    if ($diff->days == 1) {
                        LogKiemtranhatram::makeNotiLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $noti_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    } elseif ($diff->days > 2) {
                        LogKiemtranhatram::makeWarningLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $warning_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    }
                    break;
                case '1':
                    if ($diff->days == 7) {
                        LogKiemtranhatram::makeNotiLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $noti_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    } elseif ($diff->days > 8) {
                        LogKiemtranhatram::makeWarningLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $warning_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    }
                    break;
                case '2':
                    if ($diff->days == 14) {
                        LogKiemtranhatram::makeNotiLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $noti_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    } elseif ($diff->days > 15) {
                        LogKiemtranhatram::makeWarningLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $warning_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    }
                    break;
                case '3':
                    if ($diff->days == 21) {
                        LogKiemtranhatram::makeNotiLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $noti_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    } elseif ($diff->days > 22) {
                        LogKiemtranhatram::makeWarningLog($tram->ID_TRAM, $diff->days, $tram->ID_NHANVIEN);
                        $warning_array[$tram->iDNHANVIEN->DIEN_THOAI][] = $tram->TEN_TRAM;
                    }
                    break;
                
                default:
                    break;
            }
        }
        $noti_keys = array_keys($noti_array);
        $warning_keys = array_keys($warning_array);

        foreach ($noti_keys as $key) {
            $nhanvien = Nhanvien::findOne(['DIEN_THOAI' => $key]);
            $model = new LogSms;
            $model->id_nhanvien = $nhanvien->ID_NHANVIEN;
            $model->sdt = $key;
            $model->noidung = "[NHAC NHO] Cac nha tram den han kiem tra/ve sinh ngay mai: ". implode(", ", $noti_array[$key]);
            $model->created_at = time();
            $model->save(false);
        }
        foreach ($warning_keys as $key) {
            $nhanvien = Nhanvien::findOne(['DIEN_THOAI' => $key]);
            $model = new LogSms;
            $model->id_nhanvien = $nhanvien->ID_NHANVIEN;
            $model->sdt = $key;
            $model->noidung = "[CANH BAO] Ban chua kiem tra/ve sinh cac nha tram sau: ". implode(", ", $warning_array[$key]);
            $model->created_at = time();
            $model->save(false);
        }
        echo "Success!!";
    }

    /*
     * Action SMS dc chay hang ngay luc 7h30 toi.
     * Lay cac SMS duoc tao ra o action check ktnt trong ngay
     * chuyen qua Oracle DB
     */
    public function actionSms()
    {
        $listTram = Tramvt::find()->limit(10)->all();
        foreach ($listTram as $tram) {
            LogKiemtranhatram::makeNotiLog($tram->ID_TRAM, 3, $tram->ID_NHANVIEN);
        }
        // $command= Yii::$app->db_sms->createCommand(
        //     "INSERT INTO SMS_SEND 
        //         (ALARMID,TIMECREATE,SMSTYPE,SMSMOBILE,CONTENT,SENDED,USERNAME)
        //     VALUES (:salarmid,sysdate,:stype,:smobile,:scontent,:sissend,:suser)");        
        // $parameters = array(':salarmid'=>911911911,':stype'=>'SMARTBASE',':smobile'=>$phonenumber,':scontent'=>$str,':sissend'=>0,':suser'=>'SMAPID');
    }

    public function actionTest()
    {
        $start = time();
        $listTram = Tramvt::find()->all();
        $bdt = Baoduongtong::findOne(1);
        // var_dump($bdt); die;
        // foreach ($listTram as $tram) {
        //     $dbd = new Dotbaoduong;
        //     $dbd->MA_DOTBD = $bdt->MA_BDT ."-". $tram->ID_TRAM;
        //     $dbd->ID_TRAM = $tram->ID_TRAM;
        //     $dbd->ID_BDT = $bdt->ID_BDT;
        //     $dbd->TRANGTHAI = 'dangthuchien';
        //     $dbd->NGAY_DUKIEN = date('Y-m-d', strtotime('first day of next month'));
        //     $dbd->NGAY_KT_DUKIEN = date('Y-m-d', strtotime('last day of next month'));
        //     $dbd->ID_NHANVIEN = $tram->ID_NHANVIEN;
        //     $dbd->save(false);
        //     $listThietbitram = Thietbitram::findAll(['ID_TRAM' => $tram->ID_TRAM]);
        //     foreach ($listThietbitram as $thietbitram) {
        //         $thietbitram->congviecdinhky($dbd->NGAY_DUKIEN, $dbd->ID_DOTBD);
        //     }
        // }
        echo "Success!";
    }
}
