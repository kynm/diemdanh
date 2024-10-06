<?php

namespace app\models;

use Yii;

class Hocphitheokhoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hocphitheokhoa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TU_NGAY', 'TIEUDE', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI'], 'required'],
            [['TIEUDE'], 'string'],
            [['NGAY_DIEMDANH'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN', 'TIENHOC', 'SO_BH'], 'integer'],
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
            'TIENHOC' => 'TIỀN HỌC',
            'SOLUONG' => 'SỐ LƯỢNG',
            'SOLUONGCHUATHU' => 'SỐ LƯỢNG CHƯA THU',
            'TONGTIEN' => 'TỔNG TIỀN',
            'TONGTIENDATHU' => 'TỔNG TIỀN ĐÃ THU',
            'TONGTIENCHUATHU' => 'TỔNG TIỀN CHƯA THU',
            'SOLUONGDATHU' => 'SỐ LƯỢNG ĐÃ THU',
            'created_at' => 'NGÀY TẠO',
            'SO_BH' => 'SỐ BUỔI',
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
        return $this->hasMany(Quanlyhocphithutruoc::className(), ['ID_KHOAHOCPHI' => 'ID']);
    }
}
