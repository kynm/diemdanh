<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "daivt".
 *
 * @property integer $ID_LOP
 * @property string $MA_LOP
 * @property string $TEN_LOP
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $ID_DONVI
 *
 * @property Donvi $iDDONVI
 * @property Nhanvien[] $nhanviens
 * @property Tramvt[] $tramvts
 */
class Lophoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lophoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_LOP', 'ID_DONVI', 'ID_NHANVIEN_DIEMDANH'], 'required'],
            [['ID_DONVI'], 'integer'],
            [['MA_LOP'], 'string', 'max' => 10],
            [['TEN_LOP', 'DIA_CHI'], 'string', 'max' => 100],
            [['SO_DT'], 'string', 'max' => 20],
            [['MA_LOP'], 'unique'],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_LOP' => 'ID',
            'MA_LOP' => 'MÃ LỚP',
            'TEN_LOP' => 'TÊN LỚP',
            'DIA_CHI' => 'ĐỊA CHỈ',
            'SO_DT' => 'ĐIỆN THOẠI',
            'ID_DONVI' => 'ĐƠN VỊ',
            'ID_NHANVIEN_DIEMDANH' => 'NGƯỜI ĐIỂM DANH',
            'SOHOCSINH' => 'TỔNG SỐ HỌC SINH',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDONVI()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanviens()
    {
        return $this->hasMany(Nhanvien::className(), ['ID_LOP' => 'ID_LOP']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDshocsinh()
    {
        return $this->hasMany(Hocsinh::className(), ['ID_LOP' => 'ID_LOP']);
    }

    public function getDsdiemdanh()
    {
        return $this->hasMany(Quanlydiemdanh::className(), ['ID_LOP' => 'ID_LOP']);
    }
}
