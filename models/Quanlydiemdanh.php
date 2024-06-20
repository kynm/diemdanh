<?php

namespace app\models;

use Yii;

class Quanlydiemdanh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quanlydiemdanh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NGAY_DIEMDANH', 'TIEUDE', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI', 'ID_DIEMDANH'], 'required'],
            [['TIEUDE'], 'string'],
            [['NGAY_DIEMDANH'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN'], 'integer'],
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
            'NGAY_DIEMDANH' => 'NGÀY ĐIỂM DANH',
            'SOHSNGHI' => 'SỐ HỌC SINH NGHỈ',
            'SOHOCSINH' => 'TỔNG SỐ HỌC SINH',
            'SOHOCSINHDIHOC' => 'SỐ HỌC SINH ĐI HỌC',
            'THU' => 'THỨ',
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
}
