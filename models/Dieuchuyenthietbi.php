<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dieuchuyenthietbi".
 *
 * @property int $ID
 * @property int $ID_THIETBI
 * @property string $NGAY_CHUYEN
 * @property int $ID_TRAM_NGUON
 * @property int $ID_TRAM_DICH
 * @property string $LY_DO
 */
class Dieuchuyenthietbi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dieuchuyenthietbi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_THIETBI', 'NGAY_CHUYEN', 'ID_TRAM_NGUON', 'ID_TRAM_DICH'], 'required'],
            [['ID_THIETBI', 'ID_TRAM_NGUON', 'ID_TRAM_DICH'], 'integer'],
            [['NGAY_CHUYEN', 'LY_DO'], 'safe'],
            [['LY_DO'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_THIETBI' => 'Thiết bị',
            'NGAY_CHUYEN' => 'Ngày điều chuyển',
            'ID_TRAM_NGUON' => 'Trạm nguồn',
            'ID_TRAM_DICH' => 'Trạm đích',
            'LY_DO' => 'Lý do',
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
