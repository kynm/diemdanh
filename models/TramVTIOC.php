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
class TramVTIOC extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ioc_donvitram';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TT_VT' => 'Tên TTVT',
            'TO_QUAN_LY' => 'Tên tổ',
            'ID_DAI' => 'ID đài',
            'TRAM' => 'Tên trạm',
            'ID_TRAM' => 'Trạm',
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
