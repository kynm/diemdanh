<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $MA_DOTBD
 * @property int $ID_NHANVIEN
 * @property string $ANH
 * @property int $STT
 * @property int $type
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DOTBD', 'ID_NHANVIEN', 'ANH', 'STT', 'type'], 'required'],
            [['ID_NHANVIEN', 'STT'], 'integer'],
            [['MA_DOTBD'], 'string', 'max' => 32],
            [['ANH'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MA_DOTBD' => 'Ma  Dotbd',
            'ID_NHANVIEN' => 'Id  Nhanvien',
            'ANH' => 'Anh',
            'STT' => 'Stt',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
