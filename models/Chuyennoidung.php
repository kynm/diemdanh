<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chuyennoidung".
 *
 * @property int $ID_NHOM
 * @property string $MA_NOIDUNG
 * @property string $NOIDUNG
 * @property int $CHUKY
 * @property int $QLTRAM
 * @property string $YEUCAUNHAP
 * @property int $IS_SELECTED
 */
class Chuyennoidung extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chuyennoidung';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHOM', 'MA_NOIDUNG', 'NOIDUNG', 'CHUKY', 'QLTRAM', 'YEUCAUNHAP', 'IS_SELECTED'], 'required'],
            [['ID_NHOM', 'CHUKY'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['NOIDUNG', 'YEUCAUNHAP'], 'string', 'max' => 255],
            [['QLTRAM', 'IS_SELECTED'], 'string', 'max' => 1],
            [['MA_NOIDUNG'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHOM' => 'Nhóm',
            'MA_NOIDUNG' => 'Mã nội dung',
            'NOIDUNG' => 'Nội dung',
            'CHUKY' => 'Chu kỳ',
            'QLTRAM' => 'Qltram',
            'YEUCAUNHAP' => 'Yeucaunhap',
            'IS_SELECTED' => 'Is  Selected',
        ];
    }
}
