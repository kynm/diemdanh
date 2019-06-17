<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_sms".
 *
 * @property int $id
 * @property int $id_nhanvien
 * @property string $sdt
 * @property string $noidung
 * @property int $created_at
 */
class LogSms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_sms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_nhanvien', 'sdt', 'noidung', 'created_at'], 'required'],
            [['id_nhanvien', 'created_at'], 'integer'],
            [['sdt'], 'string', 'max' => 32],
            [['noidung'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhanvien' => 'Id Nhanvien',
            'sdt' => 'Sdt',
            'noidung' => 'Noidung',
            'created_at' => 'Created At',
        ];
    }
}
