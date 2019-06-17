<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thietbi".
 *
 * @property integer $ID_THIETBI
 * @property string $MA_THIETBI
 * @property string $TEN_THIETBI
 * @property integer $ID_NHOM
 * @property string $HANGSX
 * @property string $THONGSOKT
 * @property string $PHUKIEN
 *
 * @property Noidungbaotri[] $noidungbaotris
 * @property Nhomtbi $iDNHOM
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
            [['MA_THIETBI', 'TEN_THIETBI'], 'required'],
            [['ID_NHOM'], 'integer'],
            [['THONGSOKT', 'PHUKIEN'], 'string'],
            [['MA_THIETBI'], 'string', 'max' => 32],
            [['TEN_THIETBI', 'HANGSX'], 'string', 'max' => 255],
            [['ID_NHOM'], 'exist', 'skipOnError' => true, 'targetClass' => Nhomtbi::className(), 'targetAttribute' => ['ID_NHOM' => 'ID_NHOM']],
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
            'ID_NHOM' => 'Nhóm thiết bị',
            'HANGSX' => 'Hãng sản xuất',
            'THONGSOKT' => 'Thông số kỹ thuật',
            'PHUKIEN' => 'Phụ kiện',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDNHOM()
    {
        return $this->hasOne(Nhomtbi::className(), ['ID_NHOM' => 'ID_NHOM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThietbitrams()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_LOAITB' => 'ID_THIETBI']);
    }
}
