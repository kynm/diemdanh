<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dexuatnoidung".
 *
 * @property integer $ID_LOAITB
 * @property string $LAN_BD
 * @property string $CHUKYBAODUONG
 * @property string $MA_NOIDUNG
 *
 * @property Noidungbaotri $mANOIDUNG
 * @property Thietbi $iDLOAITB
 */
class Dexuatnoidung extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dexuatnoidung';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOAITB', 'LAN_BD', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'required'],
            [['ID_LOAITB'], 'integer'],
            [['LAN_BD', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'string', 'max' => 32],
            [['MA_NOIDUNG'], 'exist', 'skipOnError' => true, 'targetClass' => Noidungbaotri::className(), 'targetAttribute' => ['MA_NOIDUNG' => 'MA_NOIDUNG']],
            [['ID_LOAITB'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbi::className(), 'targetAttribute' => ['ID_LOAITB' => 'ID_THIETBI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_LOAITB' => 'Loại thiết bị',
            'LAN_BD' => 'Lần bảo dưỡng',
            'CHUKYBAODUONG' => 'Chu kỳ bảo dưỡng',
            'MA_NOIDUNG' => 'Các nội dung',
        ];
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
    public function getIDLOAITB()
    {
        return $this->hasOne(Thietbi::className(), ['ID_THIETBI' => 'ID_LOAITB']);
    }
}
