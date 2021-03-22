<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramvt".
 *
 * @property int $ID_TRAM
 * @property string $MA_TRAM
 * @property string $TEN_TRAM
 * @property string $DIADIEM
 * @property string $NGAY_KTNT
 * @property string $KINH_DO
 * @property string $VI_DO
 * @property int $ID_DAI
 * @property string $ID_NHANVIEN
 * @property int $LOAITRAM
 *
 * @property Dotbaoduong[] $dotbaoduongs
 */
class ThietbiIOC extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ioc_thietbi';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_TRAM' => 'ID',
            'SYSTEM' => 'Tên thiết bị',
            'TEN_CARD' => 'Tên Card',
            'KINHDO' => 'Kinh độ',
            'VIDO' => 'Vĩ độ',
            'PORT_ID' => 'PORT_ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotbaoduongs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_TRAM' => 'ID_TRAM']);
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
    public function getIDTRAM()
    {
        return $this->hasOne(TramVTIOC::className(), ['ID_TRAM' => 'ID_TRAM']);
    }
}
