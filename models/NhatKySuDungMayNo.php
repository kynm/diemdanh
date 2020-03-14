<?php

namespace app\models;

use Yii;

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
            [['ID_NV_DIEUHANH', 'ID_NV_VANHANH', 'ID_TRAM'], 'integer'],
            [['MA_BDT', 'TRANGTHAI'], 'string', 'max' => 32],
            [['GHICHU'], 'string', 'max' => 255],
            // [['ID_NV_DIEUHANH','ID_NV_VANHANH'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className()],
        ];
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
            'GHICHU' => 'Sự cố',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
