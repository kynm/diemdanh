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
 * @property integer $ID_DONVI
 * @property integer $ID_DAI
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
class Nhanvien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhanvien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_NHANVIEN', 'TEN_NHANVIEN', 'ID_DONVI'], 'required'],
            [['ID_DONVI'], 'integer'],
            [['MA_NHANVIEN'], 'string', 'max' => 10],
            [['TEN_NHANVIEN'], 'string', 'max' => 100],
            [['CHUC_VU', 'USER_NAME'], 'string', 'max' => 50],
            [['DIEN_THOAI'], 'string', 'max' => 15],
            [['GHI_CHU'], 'string', 'max' => 200],
            [['ID_DAI', 'DIEN_THOAI'], 'safe'],
            [['MA_NHANVIEN', 'USER_NAME'], 'unique'],
            [['ID_DAI'], 'exist', 'skipOnError' => true, 'targetClass' => Daivt::className(), 'targetAttribute' => ['ID_DAI' => 'ID_DAI']],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHANVIEN' => 'ID Nhân viên',
            'MA_NHANVIEN' => 'Mã nhân viên',
            'TEN_NHANVIEN' => 'Tên nhân viên',
            'CHUC_VU' => 'Chức vụ',
            'DIEN_THOAI' => 'Điện thoại',
            'ID_DONVI' => 'Đơn vị',
            'ID_DAI' => 'Đài',
            'GHI_CHU' => 'Ghi chú',
            'USER_NAME' => 'User  Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotbaoduongs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['TRUONG_NHOM' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKehoachbdtbs()
    {
        return $this->hasMany(Kehoachbdtb::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'USER_NAME']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDAI()
    {
        return $this->hasOne(Daivt::className(), ['ID_DAI' => 'ID_DAI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDONVI()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChucvu()
    {
        return $this->hasOne(Chucvu::className(), ['id' => 'CHUC_VU']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThuchienbds()
    {
        return $this->hasMany(Thuchienbd::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTramvts()
    {
        return $this->hasMany(Tramvt::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }
}
