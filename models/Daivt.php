<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "daivt".
 *
 * @property integer $ID_DAI
 * @property string $MA_DAIVT
 * @property string $TEN_DAIVT
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $ID_DONVI
 *
 * @property Donvi $iDDONVI
 * @property Nhanvien[] $nhanviens
 * @property Tramvt[] $tramvts
 */
class Daivt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'daivt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DAIVT', 'ID_DONVI'], 'required'],
            [['ID_DONVI'], 'integer'],
            [['MA_DAIVT'], 'string', 'max' => 10],
            [['TEN_DAIVT', 'DIA_CHI'], 'string', 'max' => 100],
            [['SO_DT'], 'string', 'max' => 20],
            [['MA_DAIVT'], 'unique'],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DAI' => 'ID đài',
            'MA_DAIVT' => 'Mã đài',
            'TEN_DAIVT' => 'Tên đài',
            'DIA_CHI' => 'Địa chỉ',
            'SO_DT' => 'Điện thoại',
            'ID_DONVI' => 'Đơn vị chủ quản',
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
        return $this->hasMany(Nhanvien::className(), ['ID_DAI' => 'ID_DAI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTramvts()
    {
        return $this->hasMany(Tramvt::className(), ['ID_DAIVT' => 'ID_DAI']);
    }
}
