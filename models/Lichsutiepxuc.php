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
class Lichsutiepxuc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lichsutiepxuc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhanvien_id','khachhanggh_id', 'ketqua', 'ht_tc', 'ghichu'], 'required'],
            [['nhucau', 'hotrokipthoi', 'giacuoc', 'khokhan', 'dnk_hotro', 'nhucau_hotro', 'noidung_canhotronhat'], 'string'],
            [['nhanvien_id', 'donvi_id', 'ketqua', 'ht_tc', 'nguyennhan_id'], 'integer'],
            [['nhanvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['nhanvien_id' => 'ID_NHANVIEN']],
            [['khachhanggh_id'], 'exist', 'skipOnError' => true, 'targetClass' => Khachhanggiahan::className(), 'targetAttribute' => ['khachhanggh_id' => 'id']],
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
            'khachhanggh_id' => 'Khách hàng',
            'tentrangthai' => 'Trạng thái',
            'ngay_tiepxuc' => 'Ngày tiếp xúc',
            'nhanvien_id' => 'Nhân viên liên hệ',
            'donvi_id' => 'Địa bàn',
            'nguyennhan_id' => 'Nguyên nhân',
            'nhucau' => 'Nhu cầu triển khai các dịch vụ khác?',
            'hotrokipthoi' => 'Công tác hỗ trợ có kịp thời không?',
            'giacuoc' => 'Giá cước dịch vụ, chiết khấu hoa hồng thế nào?',
            'khokhan' => 'Khó khăn khi sử dụng dịch vụ của VNPT là gì?',
            'dnk_hotro' => 'Doanh nghiệp khác đang hỗ trợ bằng hình thức nào?',
            'nhucau_hotro' => 'Anh/chị có muốn triển khai hệ thống cskh không?',
            'noidung_canhotronhat' => 'Anh/chị cần VNPT hỗ trợ nội dung nào nhất khi sử dụng dịch vụ?',
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
        return $this->hasOne(Khachhanggiahan::className(), ['id' => 'khachhanggh_id']);
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

    public function getDichvu()
    {
        return $this->hasMany(Dichvu::class, ['DICHVU_ID' => 'id']);
    }

    public function getTentrangthai()
    {
        return statusbaohong()[$this->status];
    }
}
