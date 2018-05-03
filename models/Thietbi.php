<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thietbi".
 *
 * @property integer $ID_THIETBI
 * @property string $MA_THIETBI
 * @property string $TEN_THIETBI
 * @property integer $ID_NHOMTB
 * @property string $HANGSX
 * @property string $THONGSOKT
 * @property string $PHUKIEN
 *
 * @property Dexuatnoidung[] $dexuatnoidungs
 * @property Noidungbaotri[] $noidungbaotris
 * @property Nhomtbi $iDNHOMTB
 * @property Thietbitram[] $thietbitrams
 */
class Thietbi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thietbi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_THIETBI', 'TEN_THIETBI', 'THONGSOKT'], 'required'],
            [['ID_NHOMTB'], 'integer'],
            [['THONGSOKT', 'PHUKIEN'], 'string'],
            [['MA_THIETBI'], 'string', 'max' => 32],
            [['TEN_THIETBI', 'HANGSX'], 'string', 'max' => 255],
            [['ID_NHOMTB'], 'exist', 'skipOnError' => true, 'targetClass' => Nhomtbi::className(), 'targetAttribute' => ['ID_NHOMTB' => 'ID_NHOM']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_THIETBI' => 'ID loại thiết bị',
            'MA_THIETBI' => 'Mã thiết bị',
            'TEN_THIETBI' => 'Tên thiết bị',
            'ID_NHOMTB' => 'Nhóm thiết bị',
            'HANGSX' => 'Hãng sản xuất',
            'THONGSOKT' => 'Thông số kỹ thuật',
            'PHUKIEN' => 'Phụ kiện',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDexuatnoidungs()
    {
        return $this->hasMany(Dexuatnoidung::className(), ['ID_LOAITB' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoidungbaotris()
    {
        return $this->hasMany(Noidungbaotri::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDNHOMTB()
    {
        return $this->hasOne(Nhomtbi::className(), ['ID_NHOM' => 'ID_NHOMTB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThietbitrams()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_LOAITB' => 'ID_THIETBI']);
    }
}
