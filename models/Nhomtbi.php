<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nhomtbi".
 *
 * @property integer $ID_NHOM
 * @property string $MA_NHOM
 * @property string $TEN_NHOM
 *
 * @property Noidungbaotri[] $noidungbaotris
 * @property Thietbi[] $thietbis
 */
class Nhomtbi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhomtbi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_NHOM'], 'required'],
            [['MA_NHOM'], 'string', 'max' => 32],
            [['TEN_NHOM'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHOM' => 'ID nhóm thiết bị',
            'MA_NHOM' => 'Mã nhóm',
            'TEN_NHOM' => 'Tên nhóm',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoidungbaotris()
    {
        return $this->hasMany(Noidungbaotri::className(), ['ID_NHOM' => 'ID_NHOM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThietbis()
    {
        return $this->hasMany(Thietbi::className(), ['ID_NHOMTB' => 'ID_NHOM']);
    }
}
