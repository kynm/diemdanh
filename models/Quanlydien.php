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
class Quanlydien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quanlydien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DIENLUC', 'MA_DONVIKT'], 'required'],
            [['NAM'], 'required'],
            [['TIENDIEN'], 'required'],
            [['TIENTHUE'], 'required'],
            [['TONGTIEN'], 'required'],
            [['THANG'], 'required'],
            [['THOIGIANCAPNHAT'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USER_ID' => 'Người nhập',
            'MA_DIENLUC' => 'Mã điện lực',
            'NAM' => 'Năm',
            'TIENDIEN' => 'Số tiền chưa thuế',
            'TIENTHUE' => 'Thuế VAT',
            'TONGTIEN' => 'Tiền đề nghị thanh toán',
            'THANG' => 'Tháng',
            'MA_DONVIKT' => 'MA_DONVIKT',
            'THOIGIANCAPNHAT' => 'Thời gian cập nhật',
            'IS_CHECKED' => 'Xác nhận',
        ];
    }

    public function getTRAMVT()
    {
        return $this->hasOne(TramVT::className(), ['MA_DIENLUC' => 'MA_DIENLUC']);
    }

    public function getDonvitheomaketoan()
    {
        return $this->hasOne(Donvi::className(), ['MA_DONVIKT' => 'MA_DONVIKT']);
    }
}
