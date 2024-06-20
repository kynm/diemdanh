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
class Diemdanhhocsinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diemdanhhocsinh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN', 'ID_LOP', 'ID_HOCSINH', 'ID_DIEMDANH', 'STATUS'], 'required'],
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

    public function getdiemdanh()
    {
        return $this->hasOne(Quanlydiemdanh::className(), ['ID' => 'ID_DIEMDANH']);
    }

    public function getHocsinh()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_HOCSINH']);
    }
}
