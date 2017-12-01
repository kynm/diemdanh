<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kehoachbdtb".
 *
 * @property integer $ID_DOTBD
 * @property integer $ID_THIETBI
 * @property string $MA_NOIDUNG
 * @property integer $ID_NHANVIEN
 *
 * @property Thietbitram $iDTHIETBI
 * @property Dotbaoduong $iDDOTBD
 * @property Nhanvien $iDNHANVIEN
 */
class Kehoachbdtb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kehoachbdtb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['ID_THIETBI'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbitram::className(), 'targetAttribute' => ['ID_THIETBI' => 'ID_THIETBI']],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
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
            'ID_NHANVIEN' => 'Id  Nhanvien',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
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
    public function getIDNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
