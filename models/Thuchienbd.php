<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thuchienbd".
 *
 * @property integer $ID_DOTBD
 * @property integer $ID_THIETBI
 * @property string $MA_NOIDUNG
 * @property string $NOIDUNGMORONG
 * @property integer $KETQUA
 * @property string $GHICHU
 * @property string $ID_NHANVIEN
 *
 * @property Dotbaoduong $iDDOTBD
 * @property Noidungbaotri $mANOIDUNG
 * @property Nhanvien $iDNHANVIEN
 * @property Thietbitram $iDTHIETBI
 */
class Thuchienbd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thuchienbd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['MA_NOIDUNG', 'KETQUA'], 'string', 'max' => 32],
            [['NOIDUNGMORONG', 'GHICHU'], 'string', 'max' => 255],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
            [['MA_NOIDUNG'], 'exist', 'skipOnError' => true, 'targetClass' => Noidungbaotri::className(), 'targetAttribute' => ['MA_NOIDUNG' => 'MA_NOIDUNG']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
            [['ID_THIETBI'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbitram::className(), 'targetAttribute' => ['ID_THIETBI' => 'ID_THIETBI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Id  Dotbd',
            'ID_THIETBI' => 'Id  Thietbi',
            'MA_NOIDUNG' => 'Ma  Noidung',
            'NOIDUNGMORONG' => 'Noidungmorong',
            'KETQUA' => 'Ketqua',
            'GHICHU' => 'Ghichu',
            'ID_NHANVIEN' => 'Id  Nhanvien',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDOTBD()
    {
        return $this->hasOne(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNG()
    {
        return $this->hasOne(Noidungbaotri::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }
}
