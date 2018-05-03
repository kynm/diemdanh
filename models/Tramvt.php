<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramvt".
 *
 * @property int $ID_TRAM
 * @property string $MA_TRAM
 * @property string $DIADIEM
 * @property double $KINH_DO
 * @property double $VI_DO
 * @property int $ID_DAI
 * @property int $ID_NHANVIEN
 *
 * @property Dotbaoduong[] $dotbaoduongs
 * @property Thietbitram[] $thietbitrams
 * @property Daivt $dAI
 * @property Nhanvien $nHANVIEN
 */
class Tramvt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramvt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_TRAM'], 'required'],
            [['KINH_DO', 'VI_DO'], 'number'],
            [['ID_DAI', 'ID_NHANVIEN'], 'integer'],
            [['MA_TRAM'], 'string', 'max' => 32],
            [['DIADIEM'], 'string', 'max' => 255],
            [['ID_DAI'], 'exist', 'skipOnError' => true, 'targetClass' => Daivt::className(), 'targetAttribute' => ['ID_DAI' => 'ID_DAI']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_TRAM' => 'ID',
            'MA_TRAM' => 'Mã trạm',
            'DIADIEM' => 'Địa điểm',
            'KINH_DO' => 'Kinh độ',
            'VI_DO' => 'Vĩ độ',
            'ID_DAI' => 'Đài quản lý',
            'ID_NHANVIEN' => 'Nhân viên quản lý',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotbaoduongs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_TRAMVT' => 'ID_TRAM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThietbitrams()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_TRAM' => 'ID_TRAM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDAI()
    {
        return $this->hasOne(Daivt::className(), ['ID_DAI' => 'ID_DAI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
