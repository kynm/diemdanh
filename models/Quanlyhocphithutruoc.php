<?php
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class Quanlyhocphithutruoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quanlyhocphithutruoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOTIEN', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI', 'SO_BH', 'STATUS'], 'required'],
            [['GHICHU','TIEUDE'], 'string'],
            [['NGAY_BD', 'NGAY_KT'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN', 'SOTIEN', 'TIENKHAC', 'TONGTIEN', 'ID_KHOAHOCPHI', 'TIENGIAM'], 'integer'],
            [['ID_LOP'], 'exist', 'skipOnError' => true, 'targetClass' => Lophoc::className(), 'targetAttribute' => ['ID_LOP' => 'ID_LOP']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_LOP' => 'LỚP',
            'ID_DONVI' => 'ĐƠN VỊ',
            'SO_BH' => 'SỐ BUỔI HỌC',
            'NGAY_BD' => 'NGÀY BĐ',
            'NGAY_KT' => 'NGÀY KT',
            'GHICHU' => 'GHI CHÚ',
            'SOTIEN' => 'SỐ TIỀN',
            'ID_HOCSINH' => 'HỌC SINH',
            'created_at' => 'NGÀY ĐÓNG HỌC PHÍ',
            'TIENKHAC' => 'TIỀN SÁCH/TÀI LIỆU',
            'TONGTIEN' => 'TỔNG TIỀN THU',
            'STATUS' => 'TRẠNG THÁI',
            'TIEUDE' => 'TIÊU ĐỀ',
            'TIENGIAM' => 'MIỄN GIẢM/ HỌC BỔNG'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLop()
    {
        return $this->hasOne(Lophoc::className(), ['ID_LOP' => 'ID_LOP']);
    }

    public function getDonvi()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    public function getHocsinh()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_HOCSINH']);
    }

    public function getKhoahoc()
    {
        return $this->hasOne(Hocphitheokhoa::className(), ['ID' => 'ID_KHOAHOCPHI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    public function sobuoidahoc($tungay, $denngay)
    {
        $count = $this->hocsinh ? $this->hocsinh->getDsdiemdanh()->andWhere(['between', 'date(diemdanhhocsinh.NGAY_DIEMDANH)', date($tungay), date($denngay)])->andWhere(['diemdanhhocsinh.STATUS' => 1])->count() : 0;
        return $count;
    }

    public function getDschamdiem()
    {
        return $this->hasOne(Chamdiem::className(), ['ID_LOP' => 'ID_LOP']);
    }

    public function getDanhsachkiemtra()
    {
        $dschamdiem = ArrayHelper::map($this->getDschamdiem()->andWhere(['between', 'date(chamdiem.NGAY_CHAMDIEM)', date($this->NGAY_BD), date($this->NGAY_KT)])->all(), 'ID', 'ID');
        $dschamdiemhocsinh = Chamdiemhocsinh::find()->where(['in', 'ID_CHAMDIEM', $dschamdiem])->andWhere(['ID_HOCSINH' => $this->ID_HOCSINH])->all();
        return $dschamdiemhocsinh;
    }

    public function sobuoinghi($tungay, $denngay)
    {
        $sobuoinghi = $this->hocsinh ? $this->hocsinh->getDsdiemdanh()->andWhere(['between', 'date(diemdanhhocsinh.NGAY_DIEMDANH)', date($tungay), date($denngay)])->andWhere(['diemdanhhocsinh.STATUS' => 0])->count() : 0;
        return $sobuoinghi;
    }

    public function dsngaynghihoc($tungay, $denngay)
    {
        $dsngayhoc = ArrayHelper::map($this->hocsinh->getDsdiemdanh()->andWhere(['between', 'date(diemdanhhocsinh.NGAY_DIEMDANH)', date($tungay), date($denngay)])->andWhere(['diemdanhhocsinh.STATUS' => 0])->select(["DATE_FORMAT(diemdanhhocsinh.NGAY_DIEMDANH,'%d/%m') NGAY_DIEMDANH"])->all(), 'NGAY_DIEMDANH', 'NGAY_DIEMDANH');
        return implode(',', $dsngayhoc);
    }
}
