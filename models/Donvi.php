<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donvi".
 *
 * @property integer $ID_DONVI
 * @property string $MA_DONVI
 * @property string $TEN_DONVI
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $CAP_TREN
 *
 * @property Daivt[] $daivts
 * @property Donvi $cAPTREN
 * @property Donvi[] $donvis
 * @property Nhanvien[] $nhanviens
 */
class Donvi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donvi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DONVI', 'MA_DONVI', 'CAP_TREN'], 'required'],
            [['ID_DONVI', 'CAP_TREN'], 'integer'],
            [['MA_DONVI'], 'string', 'max' => 30],
            [['TEN_DONVI', 'DIA_CHI'], 'string', 'max' => 100],
            [['SO_DT'], 'string', 'max' => 20],
            [['MA_DONVI'], 'unique'],
            [['CAP_TREN'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['CAP_TREN' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DONVI' => 'ID Đơn vị',
            'MA_DONVI' => 'Mã đơn vị',
            'TEN_DONVI' => 'Tên đơn vị',
            'DIA_CHI' => 'Địa chỉ',
            'SO_DT' => 'Điện thoại',
            'CAP_TREN' => 'Đơn vị cấp trên',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaivts()
    {
        return $this->hasMany(Daivt::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCAPTREN()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'CAP_TREN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonvis()
    {
        return $this->hasMany(Donvi::className(), ['CAP_TREN' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanviens()
    {
        return $this->hasMany(Nhanvien::className(), ['ID_DONVI' => 'ID_DONVI']);
    }
}
