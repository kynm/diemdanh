<?php

namespace app\models;

use Yii;
use Empathy\Validators\DateTimeCompareValidator;

/**
 * This is the model class for table "thietbitram".
 *
 * @property int $ID_THIETBI
 * @property int $ID_LOAITB
 * @property int $ID_TRAM
 * @property string $SERIAL_MAC
 * @property string $NGAYSX
 * @property string $NGAYSD
 * @property string $LANBAODUONGTRUOC
 * @property string $LANBAODUONGTIEP
 *
 * @property Thietbi $lOAITB
 * @property Tramvt $tRAM
 */
class Thietbitram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thietbitram';
    }

    public $VB;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOAITB', 'ID_TRAM', 'ID_THIETBI'], 'integer'],
            [['ID_LOAITB', 'ID_TRAM', 'SERIAL_MAC', 'NGAYSX', 'NGAYSD'], 'required'],
            [['NGAYSX', 'NGAYSD', 'LANBAODUONGTRUOC', 'LANBAODUONGTIEP'], 'safe'],
            [['SERIAL_MAC', 'VB'], 'string', 'max' => 255],
            [['SERIAL_MAC'], 'unique'],
            [['ID_LOAITB'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbi::className(), 'targetAttribute' => ['ID_LOAITB' => 'ID_THIETBI']],
            [['ID_TRAM'], 'exist', 'skipOnError' => true, 'targetClass' => Tramvt::className(), 'targetAttribute' => ['ID_TRAM' => 'ID_TRAM']],

            ['NGAYSX', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<='],
    
            ['NGAYSX', DateTimeCompareValidator::className(), 'compareAttribute' => 'NGAYSD', 'operator' => '<='],

            ['NGAYSD', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<='],

            ['NGAYSD', DateTimeCompareValidator::className(), 'compareAttribute' => 'LANBAODUONGTRUOC', 'operator' => '<='],

            ['LANBAODUONGTRUOC', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_THIETBI' => 'Id  Thietbi',
            'ID_LOAITB' => 'Loại thiết bị',
            'ID_TRAM' => 'Trạm',
            'SERIAL_MAC' => 'Serial  Mac',
            'NGAYSX' => 'Ngày sản xuất',
            'NGAYSD' => 'Ngày sử dụng',
            'LANBAODUONGTRUOC' => 'Ngày bảo dưỡng gần nhất',
            'LANBAODUONGTIEP' => 'Ngày bảo dưỡng tới',
            'VB' => 'Thêm mới theo dự án / văn bản'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDLOAITB()
    {
        return $this->hasOne(Thietbi::className(), ['ID_THIETBI' => 'ID_LOAITB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDTRAM()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'ID_TRAM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDOTBDs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD'])->viaTable('noidungcongviec', ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * tao cong viec dinh ky
     */
    public function congviecdinhky($time, $id)
    {
        $date_DK = new \DateTime($time);
        $date_SD = new \DateTime($this->NGAYSD);
        $diff = $date_DK->diff($date_SD);
        $months = round($diff->days / 30);
        $listNoidung = Noidungbaotrinhomtbi::findAll(['ID_NHOM' => $this->iDLOAITB->ID_NHOM]);
        foreach ($listNoidung as $noidung) {
            if (($noidung->CHUKY !== 0) && ($months % $noidung->CHUKY == 0)) {
                $congviec = new Noidungcongviec;
                $congviec->ID_DOTBD = $id;
                $congviec->ID_THIETBI = $this->ID_THIETBI;
                $congviec->MA_NOIDUNG = $noidung->MA_NOIDUNG;
                if ($noidung->QLTRAM == 1) {
                    $congviec->ID_NHANVIEN = $this->iDTRAM->ID_NHANVIEN;
                } else {
                    $congviec->ID_NHANVIEN = 0;
                }
                $congviec->save(false);
            }
        }
    }
}
