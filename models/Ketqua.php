<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ketqua".
 *
 * @property integer $ID_DOTBD
 * @property integer $ID_THIETBI
 * @property integer $KETQUA
 * @property string $GHICHU
 * @property string $ID_NHANVIEN
 * @property string $ANH1
 * @property string $ANH2
 * @property string $ANH3
 *
 * @property Dotbaoduong $iDDOTBD
 * @property Dotbaoduong $iDNHANVIEN
 * @property Thietbitram $iDTHIETBI
 */
class Ketqua extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ketqua';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'KETQUA', 'ID_NHANVIEN'], 'integer'],
            [['GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'string', 'max' => 255],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'TRUONG_NHOM']],
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
            'KETQUA' => 'Ketqua',
            'GHICHU' => 'Ghichu',
            'ID_NHANVIEN' => 'Id  Nhanvien',
            'ANH1' => 'Anh1',
            'ANH2' => 'Anh2',
            'ANH3' => 'Anh3',
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
    public function getIDNHANVIEN()
    {
        return $this->hasOne(Dotbaoduong::className(), ['TRUONG_NHOM' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }
}
