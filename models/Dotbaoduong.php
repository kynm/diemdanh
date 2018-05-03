<?php

namespace app\models;

use Yii;
use Empathy\Validators\DateTimeCompareValidator;


/**
 * This is the model class for table "dotbaoduong".
 *
 * @property int $ID_DOTBD
 * @property string $MA_DOTBD
 * @property string $NGAY_BD
 * @property int $ID_TRAMVT
 * @property string $TRANGTHAI
 * @property int $TRUONG_NHOM
 *
 * @property Baocao $baocao
 * @property Tramvt $tRAMVT
 * @property Nhanvien $tRUONGNHOM
 * @property Noidungcongviec[] $noidungcongviecs
 */
class Dotbaoduong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dotbaoduong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DOTBD', 'NGAY_BD'], 'required'],
            [['NGAY_BD'], 'safe'],
            [['ID_TRAMVT', 'TRUONG_NHOM'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['ID_TRAMVT'], 'exist', 'skipOnError' => true, 'targetClass' => Tramvt::className(), 'targetAttribute' => ['ID_TRAMVT' => 'ID_TRAM']],
            [['TRUONG_NHOM'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['TRUONG_NHOM' => 'ID_NHANVIEN']],
            ['NGAY_BD', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Id đợt bảo dưỡng',
            'MA_DOTBD' => 'Mã đợt bảo dưỡng',
            'NGAY_BD' => 'Ngày bảo dưỡng',
            'NGAY_DUKIEN' => 'Ngày dự kiến',
            'ID_TRAMVT' => 'Trạm',
            'TRANGTHAI' => 'Trạng thái',
            'TRUONG_NHOM' => 'Nhóm trưởng',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaocao()
    {
        return $this->hasOne(Baocao::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRAMVT()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'ID_TRAMVT']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRUONGNHOM()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'TRUONG_NHOM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoidungcongviecs()
    {
        return $this->hasMany(Noidungcongviec::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }
}