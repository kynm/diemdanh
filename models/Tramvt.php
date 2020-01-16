<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramvt".
 *
 * @property int $ID_TRAM
 * @property string $MA_TRAM
 * @property string $TEN_TRAM
 * @property string $DIADIEM
 * @property string $NGAY_KTNT
 * @property string $KINH_DO
 * @property string $VI_DO
 * @property int $ID_DAI
 * @property string $ID_NHANVIEN
 * @property int $LOAITRAM
 *
 * @property Dotbaoduong[] $dotbaoduongs
 */
class Tramvt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramvt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_TRAM', 'TEN_TRAM', 'ID_NHANVIEN', 'ID_DAI'], 'required'],
            [['DIADIEM'], 'string'],
            [['NGAY_KTNT'], 'safe'],
            [['ID_DAI', 'ID_NHANVIEN', 'LOAITRAM'], 'integer'],
            [['MA_TRAM'], 'string', 'max' => 32],
            [['TEN_TRAM', 'TEN_TRAM2', 'KIEUTRAM'], 'string', 'max' => 255],
            [['KINH_DO', 'VI_DO'], 'string', 'max' => 10],
            [['ID_DAI'], 'exist', 'skipOnError' => true, 'targetClass' => Daivt::className(), 'targetAttribute' => ['ID_DAI' => 'ID_DAI']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_TRAM' => 'ID',
            'MA_TRAM' => 'Mã trạm',
            'TEN_TRAM' => 'Tên trạm',
            'TEN_TRAM2' => 'Tên quản lý BTS',
            'DIADIEM' => 'Địa điểm',
            'NGAY_KTNT' => 'Ngày kiểm tra',
            'KINH_DO' => 'Kinh độ',
            'VI_DO' => 'Vĩ độ',
            'ID_DAI' => 'Đài quản lý',
            'ID_NHANVIEN' => 'Nhân viên quản lý',
            'LOAITRAM' => 'Loại trạm',
            'DIEN_THOAI' => 'Điện thoại'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotbaoduongs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_TRAM' => 'ID_TRAM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThietbitrams()
    {
        return $this->hasMany(Thietbitram::className(), ['ID_TRAM' => 'ID_TRAM']);
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
    public function getIDNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    /**
     * action tao dot ktvsnt
     */
    public function taodotktnt($ID_BDT)
    {
        
        $bdt = Baoduongtong::findOne(['ID_BDT' => $ID_BDT]);
        $dotbd = new Dotbaoduong;
        $dotbd->MA_DOTBD = $bdt->MA_BDT."_".$this->ID_TRAM;
        $dotbd->NGAY_DUKIEN = date('Y-m-d', strtotime('first day of this month'));
        $dotbd->NGAY_KT_DUKIEN = date('Y-m-d', strtotime('last day of this month'));
        $dotbd->ID_TRAM = $this->ID_TRAM;
        $dotbd->TRANGTHAI = 'kehoach';
        $dotbd->ID_NHANVIEN = $this->ID_NHANVIEN;
        $dotbd->ID_BDT = $ID_BDT;
        $dotbd->save(false);

        $csht = Thietbitram::find()->where(['SERIAL_MAC' => $this->MA_TRAM])->one();
        $listNoidungbaotri = Noidungbaotrinhomtbi::findAll(['ID_NHOM' => $csht->iDLOAITB->ID_NHOM]);
        foreach ($listNoidungbaotri as $noidung) {
            $congviec = new Noidungcongviec;
            $congviec->ID_DOTBD = $dotbd->ID_DOTBD;
            $congviec->ID_THIETBI = $csht->ID_THIETBI;
            $congviec->MA_NOIDUNG = $noidung->MA_NOIDUNG;
            $congviec->ID_NHANVIEN = $csht->iDTRAM->ID_NHANVIEN;
            $congviec->save();
        }
    
    }
}
