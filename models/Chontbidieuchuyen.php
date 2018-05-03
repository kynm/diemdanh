<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chontbidieuchuyen".
 *
 * @property int $ID_THIETBI
 * @property int $ID_TRAM_NGUON
 * @property int $ID_TRAM_DICH
 * @property string $NGAY_CHUYEN
 * @property string $LY_DO
 * @property int $IS_SELECTED
 */
class Chontbidieuchuyen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chontbidieuchuyen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_THIETBI'], 'required'],
            [['ID_THIETBI', 'ID_TRAM_NGUON', 'ID_TRAM_DICH'], 'integer'],
            [['NGAY_CHUYEN'], 'safe'],
            [['LY_DO'], 'string', 'max' => 255],
            [['IS_SELECTED'], 'string', 'max' => 4],
            [['ID_THIETBI'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_THIETBI' => 'Thiết bị',
            'ID_TRAM_NGUON' => 'Trạm nguồn',
            'ID_TRAM_DICH' => 'Trạm đích',
            'NGAY_CHUYEN' => 'Ngày  Chuyển',
            'LY_DO' => 'Lý  Do',
            'IS_SELECTED' => 'Is  Selected',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTRAMNGUON()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'ID_TRAM_NGUON']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTRAMDICH()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'ID_TRAM_DICH']);
    }
}
