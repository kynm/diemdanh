<?php

namespace app\models;

use Yii;

class Donhang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donhang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DONVI', 'ID_NHANVIEN', 'NGAY_BD', 'NGAY_KT'], 'required'],
            [['SOTIEN', 'SO_LOP', 'SO_HS', 'NHANVIEN_XL', 'STATUS'], 'integer'],
            [['GHICHU', 'NGAY_BD', 'NGAY_KT'], 'string'],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DONVI' => 'ĐƠN VỊ',
            'ID_NHANVIEN' => 'NGƯỜI YÊU CẦU',
            'NHANVIEN_XL' => 'NGƯỜI XỬ LÝ',
            'SOTIEN' => 'SỐ TIỀN',
            'SO_LOP' => 'SỐ LỚP',
            'SO_HS' => 'SỐ HỌC SINH',
            'NGAY_BD' => 'NGÀY BẮT ĐẦU',
            'NGAY_KT' => 'NGÀY KẾT THÚC',
            'GHICHU' => 'GHI CHÚ',
            'STATUS' => 'TRẠNG THÁI',
        ];
    }


    public function getDonvi()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
