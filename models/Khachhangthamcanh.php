<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donvi".
 *
 * @property integer $ID_DONVI
 * @property string $MA_DONVI
 * @property string $TEN_DONVI
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $CAP_TREN
 *
 * @property Daivt[] $daivts
 * @property Donvi $cAPTREN
 * @property Donvi[] $donvis
 * @property Nhanvien[] $nhanviens
 */
class Khachhangthamcanh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'khachhangthamcanh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TRANGTHAINANGCAP', 'nhanvien_id', 'MST','TEN_KH', 'DIACHI', 'LIENHE', 'EMAIL', 'SDT'], 'required'],
            [['TEN_KETOAN', 'link', 'taikhoan', 'matkhau', 'view'], 'string', 'max' => 100],
            [['ghichu'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'khachhanggh_id' => 'Khách hàng',
            'donvi_id' => 'Địa bàn',
            'nhanvien_id' => 'Nhân viên',
            'MST' => 'Mã số thuế',
            'TEN_KH' => 'Tên công ty',
            'DIACHI' => 'Địa chỉ',
            'LIENHE' => 'Điện thoại',
            'EMAIL' => 'Email',
            'SDT' => 'Số điện thoại',
            'TEN_KETOAN' => 'Tên kế toán',
            'ketqua' => 'KẾT QUẢ',
            'TEN_NV_KD' => 'Tên nhân viên kinh doanh',
            'NGAY_HH' => 'NGÀY HẾT HẠN',
            'link' => 'Link',
            'DICHVU_ID' => 'DỊCH VỤ',
            'matkhau' => 'Mật khẩu',
            'view' => 'view',
            'ghichu' => 'Ghi chú',
            'ngay_lh' => 'NGÀY LIÊN HỆ',
            'ds_dichvu' => 'DS dịch vụ giới thiệu',
            'ketqua' => 'Dịch vụ đồng ý sử dụng',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonvi()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'donvi_id']);
    }

    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'nhanvien_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLichsutiepxuc()
    {
        return $this->hasMany(Lichsutiepxucthamcanh::className(), ['khachhanggh_id' => 'id']);
    }

    public function getChatid()
    {
        return $this->telegram_id ? $this->telegram_id : '-1001641206920';
    }

    public function getDichvu()
    {
        return $this->hasOne(Dichvu::class, ['id' => 'DICHVU_ID']);
    }

    public function getDichvuphattrien()
    {
        $dsdichvu = Yii::$app->db->createCommand("SELECT GROUP_CONCAT(DISTINCT ten_dv SEPARATOR ', ') DS_DICHVU FROM dichvu WHERE id IN (". $this->ketqua .")")->queryAll();
        return $dsdichvu[0]['DS_DICHVU'];
    }
}
