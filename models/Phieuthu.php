<?php
namespace app\models;

use Yii;
use app\models\Thietbitram;
use app\models\TramVT;
use app\models\Quanlyhopdong;

class Phieuthu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phieuthu_csht';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_HOPDONG'], 'required'],
            [['TUNGAY'], 'required'],
            [['DENNGAY'], 'required'],
            [['SOTHANG'], 'required'],
            [['GIATIEN'], 'required'],
            [['VAT'], 'required'],
            [['TONGTIEN'], 'required'],
            [['LOAI_CHUNGTU'], 'required'],
            [['TEN_NGUOINHAN'], 'required'],
            [['SOTAIKHOAN'], 'required'],
            [['TEN_NGANHANG'], 'required'],
            [['ID_NHANVIEN'], 'required'],
            [['NGAYCAPNHAT'], 'required'],
            [['TRANGTHAI'], 'required'],
            [['MA_DONVIKT'], 'required'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_HOPDONG' => 'Hợp đồng',
            'TUNGAY' => 'Ngày bắt đầu',
            'DENNGAY' => 'Ngày kết thúc',
            'SOTHANG' => 'Số tháng',
            'GIATIEN' => 'Tiền chưa thuế',
            'VAT' => 'VAT',
            'TONGTIEN' => 'Tổng tiền',
            'LOAI_CHUNGTU' => 'Loại chứng từ',
            'TEN_NGUOINHAN' => 'Tên người nhận',
            'SOTAIKHOAN' => 'Số tài khoản',
            'TEN_NGANHANG' => 'Tên ngân hàng',
            'TRANGTHAI' => 'Trạng thái',
            'MA_DONVIKT' => 'Đơn vị',
        ];
    }

    public function getHopdong()
    {
        return $this->hasOne(Quanlyhopdong::className(), ['ID' => 'ID_HOPDONG']);
    }

    public function getDonvitheomaketoan()
    {
        return $this->hasOne(Donvi::className(), ['MA_DONVIKT' => 'MA_DONVIKT']);
    }
}
