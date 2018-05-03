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
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN'], 'required'],
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['GHICHU'], 'string'],
            [['MA_NOIDUNG', 'TRANGTHAI', 'KETQUA'], 'string', 'max' => 32],
            [['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN'], 'unique', 'targetAttribute' => ['ID_DOTBD', 'ID_THIETBI', 'MA_NOIDUNG', 'ID_NHANVIEN']],
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
            'ID_DOTBD' => 'Đợt bảo dưỡng',
            'ID_THIETBI' => 'Thiết bị',
            'MA_NOIDUNG' => 'Nội dung',
            'GHICHU' => 'Ghi chú',
            'TRANGTHAI' => 'Trạng thái',
            'ID_NHANVIEN' => 'Nhân viên',
            'KETQUA' => 'Kết quả',
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
        return $this->hasOne(Noidungbaotri::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
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
