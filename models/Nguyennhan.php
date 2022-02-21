<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chucvu".
 *
 * @property int $id
 * @property string $ten_chucvu
 * @property int $cap
 *
 * @property Nhanvien[] $nhanviens
 */
class Nguyennhan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nguyennhan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nguyennhan'], 'required'],
            [['nguyennhan'], 'string', 'max' => 64],
            [['stt'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_chucvu' => 'Chức vụ',
            'cap' => 'Cấp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanviens()
    {
        return $this->hasMany(Nhanvien::className(), ['CHUC_VU' => 'id']);
    }
}
