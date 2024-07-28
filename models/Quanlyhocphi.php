<?php

namespace app\models;

use Yii;

class Quanlyhocphi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quanlyhocphi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TU_NGAY', 'TIEUDE', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI', 'DEN_NGAY'], 'required'],
            [['TIEUDE'], 'string'],
            [['NGAY_DIEMDANH'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN', 'TIENHOC'], 'integer'],
            [['TIEUDE'], 'string', 'max' => 50],
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
            'TIEUDE' => 'TIÊU ĐỀ',
            'THU' => 'THỨ',
            'ID_LOP' => 'LỚP',
            'VANG' => 'VẮNG',
            'TU_NGAY' => 'TỪ NGÀY',
            'DEN_NGAY' => 'ĐẾN NGÀY',
            'TIENHOC' => 'SỐ TIỀN/BUỔI',
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


    public function getDschitietdiemdanh()
    {
        return $this->hasMany(Diemdanhhocsinh::className(), ['ID_DIEMDANH' => 'ID']);
    }

    public function getChitiethocphi()
    {
        return $this->hasMany(Chitiethocphi::className(), ['ID_QUANLYHOCPHI' => 'ID']);
    }
}
