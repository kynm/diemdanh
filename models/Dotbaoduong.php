<?php

namespace app\models;

use Yii;
use Empathy\Validators\DateTimeCompareValidator;

/**
 * This is the model class for table "dotbaoduong".
 *
 * @property int $ID_DOTBD
 * @property string $MA_DOTBD
 * @property string $NGAY_DUKIEN
 * @property string $NGAY_BD
 * @property string $NGAY_KT_DUKIEN
 * @property string $NGAY_KT
 * @property int $ID_TRAM
 * @property string $TRANGTHAI
 * @property string $ID_NHANVIEN
 * @property int $ID_BDT
 *
 * @property Baocao $baocao
 * @property Tramvt $tRAM
 * @property Nhanvien $nHANVIEN
 */
class Dotbaoduong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dotbaoduong';
    }

    public $donvi;
    public $dai;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DOTBD', 'NGAY_DUKIEN', 'NGAY_KT_DUKIEN', 'ID_TRAM'], 'required'],
            [['NGAY_DUKIEN', 'NGAY_BD', 'NGAY_KT_DUKIEN', 'NGAY_KT'], 'safe'],
            [['ID_TRAM', 'ID_NHANVIEN', 'ID_BDT', 'CREATED_AT', 'CREATED_BY'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['ID_TRAM'], 'exist', 'skipOnError' => true, 'targetClass' => Tramvt::className(), 'targetAttribute' => ['ID_TRAM' => 'ID_TRAM']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
            ['NGAY_DUKIEN', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '>='],
            ['NGAY_KT_DUKIEN', DateTimeCompareValidator::className(), 'compareValue' => 'NGAY_DUKIEN', 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'ID đợt bảo dưỡng',
            'MA_DOTBD' => 'Mã đợt bảo dưỡng',
            'NGAY_BD' => 'Ngày bắt đầu',
            'NGAY_DUKIEN' => 'Ngày bắt đầu dự kiến',
            'NGAY_KT' => 'Ngày kết thúc',
            'NGAY_KT_DUKIEN' => 'Ngày kết thúc dự kiến',
            'ID_TRAM' => 'Trạm',
            'ID_DAI' => 'Đài',
            'ID_DONVI' => 'Đơn vị',
            'TRANGTHAI' => 'Trạng thái',
            'ID_NHANVIEN' => 'Tổ trưởng',
            'donvi' => 'Đơn vị',
            'dai' => 'Đài viễn thông',
            'ID_BDT' => 'Bảo dưỡng tổng',
            'TTGV' => 'Trạng thái giao việc',
            'hinh_anh' => 'Hình ảnh',
            'cong_viec' => 'Công việc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaocao()
    {
        return $this->hasOne(Baocao::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRAMVT()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'ID_TRAM']);
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
    public function getNoidungcongviecs()
    {
        return $this->hasMany(Noidungcongviec::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaoduongtong()
    {
        return $this->hasOne(Baoduongtong::className(), ['ID_BDT' => 'ID_BDT']);
    }

    public function getFiles()
    {
        return [];
    }

        /**
     * action tao dot ktvsnt
     */
    public function taobaoduong($arr_nhomtbi, $id_profile)
    {
        $listThietbi = Thietbitram::find()->joinWith('iDLOAITB')->where(['thietbi.ID_NHOM' => $arr_nhomtbi, 'ID_TRAM' => $this->ID_TRAM])->all();
        $listNoidungbaotri = ProfileBaoduongNoidung::findAll(['ID_PROFILE' => $id_profile]);

        $list_noidung = Yii::$app->db->createCommand("
            SELECT * FROM profile_baoduong_noidung JOIN noidungbaotrinhomtbi ON profile_baoduong_noidung.MA_NOIDUNG = noidungbaotrinhomtbi.MA_NOIDUNG WHERE profile_baoduong_noidung.ID_PROFILE = $id_profile
        ")->queryAll();
        foreach ($listThietbi as $thietbi) {
            foreach ($listNoidungbaotri as $noidung) {
                $congviec = new Noidungcongviec;
                $congviec->ID_DOTBD = $this->ID_DOTBD;
                $congviec->ID_THIETBI = $thietbi->ID_THIETBI;
                $congviec->MA_NOIDUNG = $noidung->MA_NOIDUNG;
                $congviec->ID_NHANVIEN = 0;
                $congviec->save();
            }
        }
    }
}
