<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dexuatnoidung".
 *
 * @property int $ID_LOAITB
 * @property int $CHUKYBAODUONG
 * @property string $MA_NOIDUNG
 *
 * @property Chukybaoduong $cHUKYBAODUONG
 * @property Thietbi $lOAITB
 * @property Noidungbaotri $mANOIDUNG
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
            [['ID_LOAITB', 'MA_NOIDUNG'], 'required'],
            [['ID_LOAITB', 'CHUKYBAODUONG', 'LANBD'], 'integer'],
            [['MA_NOIDUNG'], 'string', 'max' => 32],
            [['ID_LOAITB', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'unique', 'targetAttribute' => ['ID_LOAITB', 'CHUKYBAODUONG', 'MA_NOIDUNG']],
            [['CHUKYBAODUONG'], 'exist', 'skipOnError' => true, 'targetClass' => Chukybaoduong::className(), 'targetAttribute' => ['CHUKYBAODUONG' => 'id']],
            [['ID_LOAITB'], 'exist', 'skipOnError' => true, 'targetClass' => Thietbi::className(), 'targetAttribute' => ['ID_LOAITB' => 'ID_THIETBI']],
            [['MA_NOIDUNG'], 'exist', 'skipOnError' => true, 'targetClass' => Noidungbaotri::className(), 'targetAttribute' => ['MA_NOIDUNG' => 'MA_NOIDUNG']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_LOAITB' => 'Thiết bị',
            'CHUKYBAODUONG' => 'Chu kỳ',
            'MA_NOIDUNG' => 'Nội dung',
            'LANBD' => 'Lần bảo dưỡng',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCHUKYBAODUONG()
    {
        return $this->hasOne(Chukybaoduong::className(), ['id' => 'CHUKYBAODUONG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLOAITB()
    {
        return $this->hasOne(Thietbi::className(), ['ID_THIETBI' => 'ID_LOAITB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMANOIDUNG()
    {
        return $this->hasOne(Noidungbaotri::className(), ['MA_NOIDUNG' => 'MA_NOIDUNG']);
    }
}
