<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noidungbaotrinhomtbi".
 *
 * @property int $ID_NHOM
 * @property string $MA_NOIDUNG
 * @property string $NOIDUNG
 * @property int $CHUKY
 * @property int $QLTRAM
 * @property string $YEUCAUNHAP
 *
 * @property Nhomtbi $nHOM
 */
class Noidungbaotrinhomtbi extends \yii\db\ActiveRecord
{
    public $type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noidungbaotrinhomtbi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHOM', 'MA_NOIDUNG', 'NOIDUNG', 'CHUKY', 'QLTRAM'], 'required'],
            [['ID_NHOM', 'CHUKY'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['NOIDUNG', 'YEUCAUNHAP'], 'string', 'max' => 255],
            [['QLTRAM'], 'string', 'max' => 1],
            [['MA_NOIDUNG'], 'unique'],
            [['ID_NHOM'], 'exist', 'skipOnError' => true, 'targetClass' => Nhomtbi::className(), 'targetAttribute' => ['ID_NHOM' => 'ID_NHOM']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHOM' => 'Nhóm thiết bị',
            'MA_NOIDUNG' => 'Mã nội dung',
            'NOIDUNG' => 'Nội dung',
            'CHUKY' => 'Chu kỳ',
            'QLTRAM' => 'Chịu trách nhiệm bảo dưỡng',
            'YEUCAUNHAP' => 'Yêu cầu kết quả',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHOM()
    {
        return $this->hasOne(Nhomtbi::className(), ['ID_NHOM' => 'ID_NHOM']);
    }
}
