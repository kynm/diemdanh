<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donvi".
 *
 * @property integer $ID_DONVI
 * @property string $MA_DONVI
 * @property string $TEN_DONVI
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $CAP_TREN
 *
 * @property Daivt[] $daivts
 * @property Donvi $cAPTREN
 * @property Donvi[] $donvis
 * @property Nhanvien[] $nhanviens
 */
class Donvi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donvi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DONVI', 'MA_DONVI','TEN_DONVI'], 'required'],
            [['ID_DONVI', 'CAP_TREN', 'SO_LOP', 'SO_HS', 'SHOWALL', 'DIEMDANHTHUCONG', 'HPTT', 'HP_T'], 'integer'],
            [['MA_DONVI'], 'string', 'max' => 30],
            [['TEN_DONVI', 'DIA_CHI', 'NGAY_BD', 'NGAY_KT', 'EMAIL', 'invoice_hocphithutruoc', 'invoice_hocphithang', 'linkqr'], 'string', 'max' => 100],
            ['EMAIL', 'email'],
            [['SO_DT'], 'string', 'max' => 20],
            [['MA_DONVI', 'SO_DT'], 'unique'],
            [['TTTT', 'QDLH', 'TTLH'], 'string'],
            [['CAP_TREN'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['CAP_TREN' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DONVI' => 'ID Đơn vị',
            'MA_DONVIKT' => 'Mã Phần mềm toán',
            'MA_DONVI' => 'Mã đơn vị',
            'TEN_DONVI' => 'Tên đơn vị',
            'DIA_CHI' => 'Địa chỉ',
            'SO_DT' => 'Điện thoại',
            'CAP_TREN' => 'Đơn vị cấp trên',
            'TTTT' => 'THÔNG TIN THANH TOÁN',
            'QDLH' => 'QUY ĐỊNH LỚP HỌC',
            'TTLH' => 'THÔNG TIN LIÊN HỆ',
            'SO_LOP' => 'SỐ LỚP TỐI ĐA',
            'SO_HS' => 'SỐ HS TỐI ĐA',
            'NGAY_BD' => 'NGÀY BẮT ĐẦU',
            'NGAY_KT' => 'NGÀY HẾT HẠN',
            'LUOTDIEMDANH' => 'LƯỢT ĐIỂM DANH',
            'NHANVIEN' => 'NHÂN VIÊN',
            'HOCSINH' => 'HỌC SINH',
            'SHOWALL' => 'HIỂN THỊ TOÀN BỘ THÔNG TIN HỌC VIÊN KHI ĐIỂM DANH',
            'DIEMDANHTHUCONG' => 'ĐIỂM DANH THỦ CÔNG (KHÔNG TỰ ĐỘNG TẠO ĐIỂM DANH CHO CẢ LỚP, THỰC HIỆN ĐIỂM DANH HỌC SINH NÀO THÌ GHI NHẬN HỌC SINH ĐÓ)',
            'HPTT' => 'HỌC PHÍ THU TRƯỚC',
            'HP_T' => 'HỌC PHÍ THEO THÁNG',
            'invoice_hocphithutruoc' => 'Mẫu học phí thu trước',
            'invoice_hocphithang' => 'Mẫu học phí theo tháng',
            'linkqr' => 'Link QR thanh toán',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLophoc()
    {
        return $this->hasMany(Lophoc::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    public function getHocsinh()
    {
        return $this->hasMany(Hocsinh::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCAPTREN()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'CAP_TREN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonvis()
    {
        return $this->hasMany(Donvi::className(), ['CAP_TREN' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanviens()
    {
        return $this->hasMany(Nhanvien::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    public function getDsdiemdanh()
    {
        return $this->hasMany(Quanlydiemdanh::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    public function getChatid()
    {
        return $this->telegram_id ? $this->telegram_id : '-1001641206920';
    }

    public function getDsdonhang()
    {
        return $this->hasMany(Donhang::className(), ['ID_DONVI' => 'ID_DONVI']);
    }
}
