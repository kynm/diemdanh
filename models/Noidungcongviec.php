<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noidungcongviec".
 *
 * @property int $ID_DOTBD
 * @property int $ID_THIETBI
 * @property string $MA_NOIDUNG
 * @property string $GHICHU
 * @property string $TRANGTHAI
 * @property int $ID_NHANVIEN
 * @property string $KETQUA
 *
 * @property Dotbaoduong $dOTBD
 * @property Noidungbaotri $mANOIDUNG
 * @property Nhanvien $nHANVIEN
 * @property Thietbitram $tHIETBI
 */
class Noidungcongviec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noidungcongviec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['GHICHU', 'KIENNGHI', 'SOLIEUTHUCTE', 'ANH'], 'string'],
            [['MA_NOIDUNG', 'TRANGTHAI', 'KETQUA', 'KETQUAXULY'], 'string', 'max' => 32],
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN'], 'unique', 'targetAttribute' => ['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN']],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
            [['MA_NOIDUNG'], 'exist', 'skipOnError' => true, 'targetClass' => Noidungbaotrinhomtbi::className(), 'targetAttribute' => ['MA_NOIDUNG' => 'MA_NOIDUNG']],
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
            'ID_DOTBD' => 'Đợt bảo dưỡng',
            'ID_THIETBI' => 'Thiết bị',
            'MA_NOIDUNG' => 'Nội dung',
            'GHICHU' => 'Ghi chú',
            'TRANGTHAI' => 'Trạng thái',
            'ID_NHANVIEN' => 'Nhân viên',
            'NOIDUNG' => 'Nội dung',
            'NGAY_BD' => 'Ngày bảo dưỡng',
            
            'ID_TRAM' => 'Trạm',
            'ID_DAI' => 'Đài',
            'ID_DONVI' => 'Đơn vị',
            'xacnhan' => 'Xác nhận',
            'ANH' => 'Ảnh',
            'KIENNGHI' => 'Kiến nghị',
            'KETQUA' => 'Kết quả',
            'SOLIEUTHUCTE' => 'Số liệu thực tế',
            'KETQUAXULY' => 'Kết quả sau xử lý'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOTBD()
    {
        return $this->hasOne(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNG()
    {
        return $this->hasOne(Noidungbaotrinhomtbi::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHIETBI()
    {
        return $this->hasOne(Thietbitram::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }
}
