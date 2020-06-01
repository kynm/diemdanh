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
class Dongiamayno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dongiamayno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN'], 'required'],
            [['LOAI_NHIENLIEU'], 'required'],
            [['THANG'], 'required'],
            [['NAM'], 'required'],
            [['DONGIA'], 'required'],
            [['DONGIA'], 'number'],
            [['ID_DONVI'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHANVIEN' => 'ID',
            'LOAI_NHIENLIEU' => 'Loại nhiên liệu',
            'THANG' => 'Tháng',
            'NAM' => 'Năm',
            'DONGIA' => 'Đơn giá',
            'ID_DONVI' => 'Đơn vị',
        ];
    }
}
