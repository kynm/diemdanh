<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nhanvien".
 *
 * @property string $ID_NHANVIEN
 * @property string $MA_NHANVIEN
 * @property string $TEN_NHANVIEN
 * @property string $CHUC_VU
 * @property string $DIEN_THOAI
 * @property integer $donvi_id
 * @property integer $dai_id
 * @property string $GHI_CHU
 * @property string $USER_NAME
 *
 * @property Dotbaoduong[] $dotbaoduongs
 * @property Kehoachbdtb[] $kehoachbdtbs
 * @property Daivt $iDDAI
 * @property Donvi $iDDONVI
 * @property Thuchienbd[] $thuchienbds
 * @property Tramvt[] $tramvts
 */
class Dichvubaohong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dichvu_baohong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dichvu_id', 'baohong_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dichvu_id' => 'Tên dịch vụ',
            'baohong_id' => 'Báo hỏng',
        ];
    }
}
