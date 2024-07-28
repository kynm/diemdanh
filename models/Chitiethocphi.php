<?php

namespace app\models;

use Yii;

class Chitiethocphi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chitiethocphi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN', 'ID_HOCSINH', 'ID_QUANLYHOCPHI'], 'required'],
            [['NHAN_XET', 'NGAY_NGHI', 'NGAYDIHOC'], 'safe'],
            [['SO_BH', 'SO_BDH', 'SO_BN', 'TONG_TIEN', 'SO_BTT', 'TIENHOC'], 'integer'],
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
            'TIEUDE' => 'TIÊU ĐỀ',
            'THU' => 'THỨ',
            'ID_LOP' => 'LỚP',
            'VANG' => 'VẮNG',
            'TU_NGAY' => 'TỪ NGÀY',
            'DEN_NGAY' => 'ĐẾN NGÀY',
            'NGAY_NGHI' => 'NGÀY NGHỈ',
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

    public function getHocphi()
    {
        return $this->hasOne(Quanlyhocphi::className(), ['ID' => 'ID_QUANLYHOCPHI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
