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
            [['ID_LOP', 'ID_NHANVIEN', 'TIENHOC'], 'integer'],
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
            'TIENHOC' => 'SỐ TIỀN MỖI BUỔI HỌC'
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
}
