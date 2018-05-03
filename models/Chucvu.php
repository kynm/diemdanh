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
class Chucvu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chucvu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten_chucvu', 'cap'], 'required'],
            [['ten_chucvu'], 'string', 'max' => 64],
            [['cap'], 'string', 'max' => 4],
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
