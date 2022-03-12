<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
 * @property Donvi $nHANVIENXULY
 * @property Thuchienbd[] $thuchienbds
 * @property Tramvt[] $tramvts
 */
class Hotrott32to78 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lichsuhotrott32to78';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhanvien_id','hddtmoi_id', 'ketqua', 'ht_tc'], 'required'],
            [['nhanvien_id', 'donvi_id', 'ketqua', 'ht_tc'], 'integer'],
            [['nhanvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['nhanvien_id' => 'ID_NHANVIEN']],
            [['hddtmoi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hddtmoi::className(), 'targetAttribute' => ['hddtmoi_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ketqua' => 'Kết quả',
            'ht_tc' => 'Hình thức tiếp xúc',
            'ghichu' => 'Ghi chú',
            'hddtmoi_id' => 'Khách hàng',
            'tentrangthai' => 'Trạng thái',
            'ngay_tiepxuc' => 'Ngày tiếp xúc',
            'nhanvien_id' => 'Nhân viên liên hệ',
            'donvi_id' => 'Địa bàn',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'nhanvien_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKhachhang()
    {
        return $this->hasOne(Hddtmoi::className(), ['id' => 'hddtmoi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDONVI()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'donvi_id']);
    }

    // public function getDichvu()
    // {
    //     return $this->hasOne(Dichvu::className(), ['id' => 'dichvu_id']);
    // }

    public function getNguyennhan()
    {
        return $this->hasOne(Nguyennhan::className(), ['id' => 'nguyennhan_id']);
    }

    public function getDichvubaohong()
    {
        return $this->hasMany(Dichvubaohong::class, ['baohong_id' => 'id']);
    }

    public function getDichvu()
    {
        return $this->hasMany(Dichvu::class, ['id' => 'dichvu_id'])
            ->via('dichvubaohong');
    }

    public function getTendsdichvu()
    {
        $dsdv = ArrayHelper::map($this->dichvu, 'id', 'ten_dv');
        return implode($dsdv, ', ');
    }

    public function getTentrangthai()
    {
        return statusbaohong()[$this->status];
    }
}
