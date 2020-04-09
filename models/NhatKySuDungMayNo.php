<?php

namespace app\models;

use Yii;
use app\models\Nhanvien;
use app\models\Thietbitram;

/**
 * This is the model class for table "baoduongtong".
 *
 * @property int $ID_BDT
 * @property string $MA_BDT
 * @property int $TYPE
 * TYPE = [0 => Bao duong theo dot, 1 => Bao duong dinh ky, 2 => Kiem tra ve sinh nha tram]
 * @property string $MO_TA
 * @property string $TRANGTHAI
 * @property string $ID_NHANVIEN
 *
 * @property Nhanvien $nHANVIEN
 */
class NhatKySuDungMayNo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhatkysudungmayno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DINHMUC'], 'required'],
            [['ID_THIETBITRAM'], 'required'],
            [['DINHMUC'], 'required'],
            [['ID_NV_DIEUHANH', 'ID_NV_VANHANH', 'ID_TRAM'], 'integer'],
            [['THOIGIANBATDAU', 'THOIGIANKETTHUC'], 'required'],
            ['THOIGIANBATDAU','validateDates'],
        ];
    }

    public function validateDates(){
        if(strtotime($this->THOIGIANKETTHUC) <= strtotime($this->THOIGIANBATDAU)){
            $this->addError('THOIGIANBATDAU', 'Thời gian bắt đầu phải lớn hơn thời gian kết thúc');
            $this->addError('THOIGIANKETTHUC','Thời gian bắt đầu phải lớn hơn thời gian kết thúc');
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_NV_DIEUHANH' => 'Nhân viên điều hành',
            'ID_NV_VANHANH' => 'Nhân viên vận hành',
            'ID_TRAM' => 'Trạm vận hành',
            'DINHMUC' => 'Định mức',
            'GIATIEN' => 'Đơn giá',
            'THOIGIANBATDAU' => 'Thời gian bắt đầu',
            'THOIGIANKETTHUC' => 'Thời gian kết thúc',
            'GHICHU' => 'Nội dung sự cố',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIENDIEUHANH()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NV_DIEUHANH']);
    }

    public function getTHIETBITRAM()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBITRAM']);
    }

    public function getNHANVIENVANHANH()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NV_VANHANH']);
    }
}
