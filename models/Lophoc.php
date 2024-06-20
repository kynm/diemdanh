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
            'ID_LOP' => 'ID lớp',
            'MA_LOP' => 'Mã lớp',
            'TEN_LOP' => 'Tên lớp',
            'DIA_CHI' => 'Địa chỉ',
            'SO_DT' => 'Điện thoại',
            'ID_DONVI' => 'Đơn vị chủ quản',
            'ID_NHANVIEN_DIEMDANH' => 'NGƯỜI ĐIỂM DANH'
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
        return $this->hasMany(Hocsinh::className(), ['ID_LOP' => 'ID_LOP']);
    }
}
