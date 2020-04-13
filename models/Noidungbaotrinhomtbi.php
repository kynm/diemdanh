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
 * @property int $IS_PARENT
 * @property string $ID_PARENT
 * @property int $IMAGES
 * @property string $SAMPLE_RESULT
 *
 * @property ProfileBaoduongNoidung[] $profileBaoduongNoidungs
 * @property ProfileBaoduong[] $pROFILEs
 */
class Noidungbaotrinhomtbi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noidungbaotrinhomtbi';
    }

    public $type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_NHOM', 'MA_NOIDUNG', 'NOIDUNG', 'CHUKY', 'QLTRAM'], 'required'],
            [['ID_NHOM', 'CHUKY', 'QLTRAM', 'IS_PARENT', 'IMAGES'], 'integer'],
            [['SAMPLE_RESULT'], 'string'],
            [['MA_NOIDUNG', 'ID_PARENT'], 'string', 'max' => 32],
            [['NOIDUNG', 'YEUCAUNHAP'], 'string', 'max' => 255],
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

            'IS_PARENT' => 'Is parent?',
            'ID_PARENT' => 'Nội dung cấp trên',
            'IMAGES' => 'Yêu cầu hình ảnh',
            'SAMPLE_RESULT' => 'Kết quả mẫu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHOM()
    {
        return $this->hasOne(Nhomtbi::className(), ['ID_NHOM' => 'ID_NHOM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileBaoduongNoidungs()
    {
        return $this->hasMany(ProfileBaoduongNoidung::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPROFILEs()
    {
        return $this->hasMany(ProfileBaoduong::className(), ['ID' => 'ID_PROFILE'])->viaTable('profile_baoduong_noidung', ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    public function getSolieuthucte()
    {
        $result = json_decode($this->SAMPLE_RESULT, true);
        return $result['SOLIEUTHUCTE'] ? $result['SOLIEUTHUCTE']['fields'] : [];
    }
    public function getArrayResult()
    {
        $result = json_decode($this->SAMPLE_RESULT, true);
        return $result;
    }
}
