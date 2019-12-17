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
class Baoduongtong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baoduongtong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_BDT'], 'required'],
            [['TYPE', 'ID_NHANVIEN'], 'integer'],
            [['MA_BDT', 'TRANGTHAI'], 'string', 'max' => 32],
            [['MO_TA'], 'string', 'max' => 255],
            [['MA_BDT'], 'unique'],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_BDT' => 'ID',
            'MA_BDT' => 'Mã bảo dưỡng tổng',
            'TYPE' => 'Loại',
            'MO_TA' => 'Mô tả',
            'TRANGTHAI' => 'Trạng thái',
            'ID_NHANVIEN' => 'Người tạo',
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
