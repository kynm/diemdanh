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
            [['NHAN_XET'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'STATUS' => 'TRẠNG THÁI',
            'ID_HOCSINH' => 'HỌC SINH',
            'ID_LOP' => 'LỚP',
            'NHAN_XET' => 'GHI CHÚ',
            'NGAY_DIEMDANH' => 'NGÀY ĐIỂM DANH',
        ];
    }

    public function getDiemdanh()
    {
        return $this->hasOne(Quanlydiemdanh::className(), ['ID' => 'ID_DIEMDANH']);
    }

    public function getHocsinh()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_HOCSINH']);
    }

    public function getLop()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_LOP']);
    }
}
