<?php

namespace app\models;

use Yii;

class Quanlyhocphithutruoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quanlyhocphithutruoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOTIEN', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI', 'SO_BH', 'STATUS'], 'required'],
            [['GHICHU','TIEUDE'], 'string'],
            [['NGAY_BD', 'NGAY_KT'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN', 'SOTIEN', 'TIENKHAC', 'TONGTIEN'], 'integer'],
            [['ID_LOP'], 'exist', 'skipOnError' => true, 'targetClass' => Lophoc::className(), 'targetAttribute' => ['ID_LOP' => 'ID_LOP']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_LOP' => 'LỚP',
            'ID_DONVI' => 'ĐƠN VỊ',
            'SO_BH' => 'SỐ BUỔI HỌC',
            'NGAY_BD' => 'NGÀY BĐ',
            'NGAY_KT' => 'NGÀY KT',
            'GHICHU' => 'GHI CHÚ',
            'SOTIEN' => 'SỐ TIỀN',
            'ID_HOCSINH' => 'HỌC SINH',
            'created_at' => 'NGÀY ĐÓNG HỌC PHÍ',
            'TIENKHAC' => 'TIỀN SÁCH/TÀI LIỆU',
            'TONGTIEN' => 'TỔNG TIỀN THU',
            'STATUS' => 'TRẠNG THÁI',
            'TIEUDE' => 'TIÊU ĐỀ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLop()
    {
        return $this->hasOne(Lophoc::className(), ['ID_LOP' => 'ID_LOP']);
    }

    public function getHocsinh()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_HOCSINH']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}