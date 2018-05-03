<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lencongviec".
 *
 * @property int $ID_DOTBD
 * @property int $ID_THIETBI
 * @property string $MA_NOIDUNG
 * @property int $IS_SUGGESTED
 * @property int $IS_SELECTED
 */
class Lencongviec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lencongviec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'IS_SUGGESTED', 'IS_SELECTED'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG'], 'unique', 'targetAttribute' => ['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Đợt bảo dưỡng',
            'ID_THIETBI' => 'Thiết bị',
            'MA_NOIDUNG' => 'Nội dung',
            'IS_SUGGESTED' => 'Khuyến nghị?',
            'IS_SELECTED' => 'Được chọn?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOTBD()
    {
        return $this->hasOne(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNG()
    {
        return $this->hasOne(Noidungbaotri::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }
}
