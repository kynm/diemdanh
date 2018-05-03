<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noidungbaotri".
 *
 * @property string $MA_NOIDUNG
 * @property integer $ID_THIETBI
 * @property string $NOIDUNG
 *
 * @property Dexuatnoidung[] $dexuatnoidungs
 * @property Thietbi[] $iDLOAITBs
 * @property Kehoachbdtb[] $kehoachbdtbs
 * @property Ketqua[] $ketquas
 * @property Thietbi $iDTHIETBI
 * @property Thuchienbd[] $thuchienbds
 */
class Noidungbaotri extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noidungbaotri';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_NOIDUNG'], 'required'],
            [['ID_THIETBI'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['NOIDUNG'], 'string', 'max' => 255],
            [['ID_THIETBI'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbi::className(), 'targetAttribute' => ['ID_THIETBI' => 'ID_THIETBI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MA_NOIDUNG' => 'Mã nội dung',
            'ID_THIETBI' => 'Thiết bị',
            'NOIDUNG' => 'Nội dung',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDexuatnoidungs()
    {
        return $this->hasMany(Dexuatnoidung::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDLOAITBs()
    {
        return $this->hasMany(Thietbi::className(), ['ID_THIETBI' => 'ID_LOAITB'])->viaTable('dexuatnoidung', ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKehoachbdtbs()
    {
        return $this->hasMany(Kehoachbdtb::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKetquas()
    {
        return $this->hasMany(Ketqua::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBI()
    {
        return $this->hasOne(Thietbi::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThuchienbds()
    {
        return $this->hasMany(Thuchienbd::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }
}
