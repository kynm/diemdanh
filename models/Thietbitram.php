<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thietbitram".
 *
 * @property integer $ID_THIETBI
 * @property integer $ID_LOAITB
 * @property integer $ID_TRAM
 * @property string $SERIAL_MAC
 * @property string $NGAYSX
 * @property string $NGAYSD
 * @property integer $LANBD
 * @property string $LANBAODUONGTRUOC
 * @property string $LANBAODUONGTIEP
 *
 * @property Kehoachbdtb[] $kehoachbdtbs
 * @property Ketqua[] $ketquas
 * @property Dotbaoduong[] $iDDOTBDs
 * @property Thietbi $iDLOAITB
 * @property Tramvt $iDTRAM
 * @property Thuchienbd[] $thuchienbds
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOAITB', 'ID_TRAM', 'LANBD', 'ID_THIETBI'], 'integer'],
            [['SERIAL_MAC', 'NGAYSX', 'NGAYSD'], 'required'],
            [['NGAYSX', 'NGAYSD', 'LANBAODUONGTRUOC', 'LANBAODUONGTIEP'], 'safe'],
            [['SERIAL_MAC'], 'string', 'max' => 255],
            [['SERIAL_MAC'], 'unique'],
            [['ID_LOAITB'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbi::className(), 'targetAttribute' => ['ID_LOAITB' => 'ID_THIETBI']],
            [['ID_TRAM'], 'exist', 'skipOnError' => true, 'targetClass' => Tramvt::className(), 'targetAttribute' => ['ID_TRAM' => 'ID_TRAM']],
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
            'LANBD' => 'Lần bảo dưỡng',
            'LANBAODUONGTRUOC' => 'Lần bảo dưỡng trước',
            'LANBAODUONGTIEP' => 'Lần bảo dưỡng tiếp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKehoachbdtbs()
    {
        return $this->hasMany(Kehoachbdtb::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKetquas()
    {
        return $this->hasMany(Ketqua::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDOTBDs()
    {
        return $this->hasMany(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD'])->viaTable('ketqua', ['ID_THIETBI' => 'ID_THIETBI']);
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
    public function getThuchienbds()
    {
        return $this->hasMany(Thuchienbd::className(), ['ID_THIETBI' => 'ID_THIETBI']);
    }
}
