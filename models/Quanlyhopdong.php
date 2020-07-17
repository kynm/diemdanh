<?php

namespace app\models;

use Yii;
use app\models\Nhanvien;
use app\models\Thietbitram;
use app\models\TramVT;
use app\models\Donvi;


/**
 * This is the model class for table "baoduongtong".
 *
 * @property int $ID_BDT
 * @property string $MA_BDT
 * @property int $TYPE
 * TYPE = [0 => Bao duong theo dot, 1 => Bao duong dinh ky, 2 => Kiem tra ve sinh nha tram]
 * @property string $MO_TA
 * @property string $TRANGTHAI
 * @property string $ID_NHANVIEN
 *
 * @property Nhanvien $nHANVIEN
 */
class Quanlyhopdong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hopdong_csht';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_CSHT'], 'required'],
            [['NGAYKY'], 'required'],
            [['NGAY_BD'], 'required'],
            [['NGAYKT'], 'required'],
            [['TEN_VT'], 'required'],
            [['DIACHI'], 'required'],
            [['NGUOIDAIDIEN_A'], 'required'],
            [['NGUOIDAIDIEN_B'], 'required'],
            [['MA_HOPDONG'], 'required'],
            [['TEN_HOPDONG'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MA_CSHT' => 'Mã cơ sở hạ tầng',
            'NGAYKY' => 'Ngày ký',
            'NGAY_BD' => 'Ngày bắt đầu',
            'NGAYKT' => 'Ngày kết thúc',
            'TEN_VT' => 'Tên đơn vị',
            'NGUOIDAIDIEN_A' => 'Đại diện bên A',
            'NGUOIDAIDIEN_B' => 'Đại diện bên B',
            'DIACHI' => 'Địa chỉ',
            'MA_HOPDONG' => 'Mã hợp đồng',
            'TEN_HOPDONG' => 'Tên hợp đồng',
        ];
    }

    public function getTRAMVT()
    {
        return $this->hasOne(TramVT::className(), ['MA_CSHT' => 'MA_CSHT']);
    }

}
