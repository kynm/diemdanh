<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dotbaoduong".
 *
 * @property integer $ID_DOTBD
 * @property string $MA_DOTBD
 * @property string $NGAY_BD
 * @property integer $ID_TRAMVT
 * @property string $TRANGTHAI
 * @property integer $TRUONG_NHOM
 *
 * @property Tramvt $iDTRAMVT
 * @property Nhanvien $tRUONGNHOM
 * @property Kehoachbdtb[] $kehoachbdtbs
 * @property Thietbitram[] $iDTHIETBIs
 * @property Ketqua[] $ketquas
 * @property Ketqua[] $ketquas0
 * @property Thietbitram[] $iDTHIETBIs0
 * @property Thuchienbd[] $thuchienbds
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
            [['MA_DOTBD', 'NGAY_BD', 'TRANGTHAI'], 'required'],
            [['NGAY_BD'], 'safe'],
            [['ID_TRAMVT', 'TRUONG_NHOM'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['ID_TRAMVT'], 'exist', 'skipOnError' => true, 'targetClass' => Tramvt::className(), 'targetAttribute' => ['ID_TRAMVT' => 'ID_TRAM']],
            [['TRUONG_NHOM'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['TRUONG_NHOM' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Id  Dotbd',
            'MA_DOTBD' => 'Ma  Dotbd',
            'NGAY_BD' => 'Ngay  Bd',
            'ID_TRAMVT' => 'Id  Tramvt',
            'TRANGTHAI' => 'Trangthai',
            'TRUONG_NHOM' => 'Truong  Nhom',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTRAMVT()
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
    public function getKehoachbdtbs()
    {
        return $this->hasMany(Kehoachbdtb::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBIs()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI'])->viaTable('kehoachbdtb', ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKetquas()
    {
        return $this->hasMany(Ketqua::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKetquas0()
    {
        return $this->hasMany(Ketqua::className(), ['ID_NHANVIEN' => 'TRUONG_NHOM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBIs0()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI'])->viaTable('ketqua', ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThuchienbds()
    {
        return $this->hasMany(Thuchienbd::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }
}
