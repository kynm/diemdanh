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
class Nhantin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhantin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noidung', 'donvinhan'], 'required'],
            [['donvinhan'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'noidung' => 'Nội dung tin nhắn',
            'donvinhan' => 'Danh sách đơn vị nhận',
        ];
    }
}
