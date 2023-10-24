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
class Chuanhoamauhoadon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chuanhoahddt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LOAITB_ID', 'MST','DIACHI_LD', 'DIACHI', 'LIENHE', 'MA_TB', 'SDT'], 'required'],
            [['ketqua', 'nhanvien_id'], 'integer'],
            [['ngay_yc', 'ngay_sua', 'ngay_dong'], 'datetime'],
            [['ghichu', 'nhucau', 'ghichu_xl'], 'string', 'max' => 1000],
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
            'nhanvien_id' => 'Nhân viên sửa mẫu',
            'MST' => 'Mã số thuế',
            'DIACHI_LD' => 'Tên công ty',
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
            'ghichu' => 'Ghi chú yêu cầu',
            'ghichu_xl' => 'Ghi chú xử lý',
            'ngay_yc' => 'Ngày yêu cầu',
            'ngay_sua' => 'Ngày sửa',
            'ngay_dong' => 'Ngày đóng',
            'MA_TB' => 'MÃ THUÊ BAO',
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
        return $this->hasMany(Lichsutiepxuc::className(), ['khachhanggh_id' => 'id']);
    }

    public function getChatid()
    {
        return $this->telegram_id ? $this->telegram_id : '-1001641206920';
    }

    public function getDichvu()
    {
        return $this->hasOne(Dichvu::class, ['id' => 'DICHVU_ID']);
    }

    public function getImages()
    {
        return $this->hasMany(Anhchuanhoa::className(), ['chuanhoa_id' => 'id']);
    }

    public function getAnhtruocchuanhoa()
    {
        return $this->getImages()->where(['type' => 1]);
    }

    public function getAnhsauchuanhoa()
    {
        return $this->getImages()->where(['type' => 2]);
    }
}
