<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_baoduong_noidung".
 *
 * @property int $ID_PROFILE
 * @property string $MA_NOIDUNG
 *
 * @property Noidungbaotrinhomtbi $mANOIDUNG
 * @property ProfileBaoduong $pROFILE
 */
class ProfileBaoduongNoidung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_baoduong_noidung';
    }

    /**
     * @inheritdoc
     */
    public function __construct($id = null, $item = null)
    {
        $this->ID_PROFILE = $id;
    }

    /**
     * Grands a roles from a user.
     * @param array $items
     * @return integer number of successful grand
     */
    public function assign($item)
    {
        $success = 0;
        try {
            $this->MA_NOIDUNG = $item;
            $this->save();
            $success++;
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        return $success;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_PROFILE', 'MA_NOIDUNG'], 'required'],
            [['ID_PROFILE'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['ID_PROFILE', 'MA_NOIDUNG'], 'unique', 'targetAttribute' => ['ID_PROFILE', 'MA_NOIDUNG']],
            [['MA_NOIDUNG'], 'exist', 'skipOnError' => true, 'targetClass' => Noidungbaotrinhomtbi::className(), 'targetAttribute' => ['MA_NOIDUNG' => 'MA_NOIDUNG']],
            [['ID_PROFILE'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileBaoduong::className(), 'targetAttribute' => ['ID_PROFILE' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_PROFILE' => 'Loại bảo dưỡng',
            'MA_NOIDUNG' => 'Mã nội dung',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNG()
    {
        return $this->hasOne(Noidungbaotrinhomtbi::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPROFILE()
    {
        return $this->hasOne(ProfileBaoduong::className(), ['ID' => 'ID_PROFILE']);
    }
}
