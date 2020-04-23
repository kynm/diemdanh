<?php

namespace app\models;

use Yii;
use app\models\Nhanvien;
use app\models\Thietbitram;
use app\models\TramVT;

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
            [['IS_CHECKED'], 'required'],
            [['DINHMUC'], 'required'],
            [['ID_THIETBITRAM'], 'required'],
            [['USER_ID'], 'required'],
            [['DINHMUC'], 'required'],
            [['LOAI_SU_CO'], 'required'],
            [['ID_NV_DIEUHANH', 'ID_NV_VANHANH', 'ID_TRAM'], 'integer'],
            [['ID_NV_DIEUHANH', 'ID_NV_VANHANH', 'ID_TRAM'], 'required'],
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
            'ID_NV_VANHANH' => 'Người chạy máy nổ',
            'USER_ID' => 'Người nhập liệu',
            'ID_TRAM' => 'Trạm vận hành',
            'DINHMUC' => 'Định mức',
            'GIATIEN' => 'Đơn giá',
            'THOIGIANBATDAU' => 'Thời gian bắt đầu',
            'THOIGIANKETTHUC' => 'Thời gian kết thúc',
            'GHICHU' => 'Nội dung sự cố',
            'LOAI_SU_CO' => 'Loại sự cố',
            'soluong' => 'Số lượng (L)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIENDIEUHANH()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NV_DIEUHANH']);
    }

    public function getHous()
    {
        $dinhmuc = json_decode($this->tHIETBITRAM->THAMSOTHIETBI)->DINH_MUC;
        $expectedStartTime = new \DateTime($this->THOIGIANBATDAU);
        $expectedEndTime = new \DateTime($this->THOIGIANKETTHUC);
        $diff = $expectedEndTime->diff($expectedStartTime, true);

        return ($diff->i + ($diff->h*60)+ ($diff->d*24*60));
    }

    public function getSoluong()
    {
        return $this->hous * json_decode($this->tHIETBITRAM->THAMSOTHIETBI)->DINH_MUC / 60;
    }

    public function getNGUOITAO()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'USER_ID']);
    }

    public function getTHIETBITRAM()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBITRAM']);
    }

    public function getTRAMVANHANH()
    {
        return $this->hasOne(TramVT::className(), ['ID_TRAM' => 'ID_TRAM']);
    }

    public function getNHANVIENVANHANH()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NV_VANHANH']);
    }
}
