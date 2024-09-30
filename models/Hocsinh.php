<?php

namespace app\models;

use Yii;

class Hocsinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hocsinh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_HOCSINH', 'HO_TEN', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI'], 'required'],
            [['HO_TEN', 'SO_DT', 'DIA_CHI', 'GHICHU'], 'string'],
            [['NGAY_SINH', 'NGAY_BD', 'NGAY_KT'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN', 'TIENHOC', 'SOBH_DAMUA', 'SOBH_DAHOC', 'HT_HP'], 'integer'],
            [['MA_HOCSINH'], 'string', 'max' => 32],
            [['HO_TEN'], 'string', 'max' => 100],
            [['MA_HOCSINH'], 'unique'],
            [['ID_LOP'], 'exist', 'skipOnError' => true, 'targetClass' => Lophoc::className(), 'targetAttribute' => ['ID_LOP' => 'ID_LOP']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MA_HOCSINH' => 'Mã HỌC SINH',
            'HO_TEN' => 'HỌ TÊN',
            'SO_DT' => 'ĐIỆN THOẠI',
            'ID_LOP' => 'LỚP',
            'ID_DONVI' => 'ĐƠN VỊ',
            'NGAY_SINH' => 'NGÀY SINH',
            'DIA_CHI' => 'ĐỊA CHỈ',
            'NGAY_BD' => 'NGÀY BĐ',
            'NGAY_KT' => 'NGÀY KT',
            'GHICHU' => 'GHI CHÚ',
            'TIENHOC' => 'SỐ TIỀN MỖI BUỔI HỌC',
            'CHANGE_STATUS' => 'ĐỔI TRẠNG THÁI',
            'STATUS' => 'TRẠNG THÁI',
            'SOBH_DAMUA' => 'SỐ BUỔI ĐÃ NỘP',
            'SOBH_DAHOC' => 'SỐ BUỔI ĐÃ HỌC',
            'HT_HP' => 'HÌNH THỨC NỘP HỌC PHÍ',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLop()
    {
        return $this->hasOne(Lophoc::className(), ['ID_LOP' => 'ID_LOP']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    public function getTrangthai()
    {
        return $this->hasOne(Trangthaihocsinh::className(), ['MA_TRANGTHAI' => 'STATUS']);
    }

    public function getDshocphi()
    {
        return $this->hasOne(Chitiethocphi::className(), ['ID_HOCSINH' => 'ID']);
    }

    public function getDshocphithutruoc()
    {
        return $this->hasOne(Quanlyhocphithutruoc::className(), ['ID_HOCSINH' => 'ID']);
    }

    public function getDsdiemdanh()
    {
        return $this->hasMany(Diemdanhhocsinh::className(), ['ID_HOCSINH' => 'ID']);
    }
}
