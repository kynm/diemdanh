<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_baoduong".
 *
 * @property int $ID
 * @property string $TEN_PROFILE
 *
 * @property ProfileBaoduongNoidung[] $profileBaoduongNoidungs
 * @property Noidungbaotrinhomtbi[] $mANOIDUNGs
 */
class ProfileBaoduong extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_baoduong';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TEN_PROFILE'], 'required'],
            [['TEN_PROFILE'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TEN_PROFILE' => 'Tên Profile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileBaoduongNoidungs()
    {
        return $this->hasMany(ProfileBaoduongNoidung::className(), ['ID_PROFILE' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNGs()
    {
        return $this->hasMany(Noidungbaotrinhomtbi::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG'])->viaTable('profile_baoduong_noidung', ['ID_PROFILE' => 'ID']);
    }
}
