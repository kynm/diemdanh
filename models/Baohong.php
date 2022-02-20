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
class Baohong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baohong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['donvi_id','dichvu_id','ten_kh', 'so_dt', 'diachi', 'noidung'], 'required'],
            [['user_id', 'donvi_id', 'nhanvien_xl_id', 'dichvu_id'], 'integer'],
            [['ten_kh'], 'string', 'max' => 20],
            [['diachi'], 'string', 'max' => 200],
            [['so_dt'], 'string', 'max' => 11],
            [['noidung'], 'string', 'max' => 500],
            [['dai_id', 'so_dt'], 'safe'],
            [['donvi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['donvi_id' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'donvi_id' => 'Trung tâm viễn thông',
            'nhanvien_xl_id' => 'Nhân viên xử lý',
            'user_id' => 'Nhân viên phản ánh',
            'dichvu_id' => 'Dịch vụ phản ánh',
            'ten_kh' => 'Tên khách hàng',
            'so_dt' => 'Số điện thoại',
            'dai_id' => 'Đài',
            'noidung' => 'Nội dung phản ánh',
            'diachi' => 'Địa chỉ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotbaoduongs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
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
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'user_id']);
    }

    public function getNHANVIENXULY()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'nhanvien_xl_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDAI()
    {
        return $this->hasOne(Daivt::className(), ['ID_DAI' => 'dai_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDONVI()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'donvi_id']);
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
