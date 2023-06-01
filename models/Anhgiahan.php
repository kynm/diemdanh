<?php

namespace app\models;
use Yii;

class Anhgiahan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anhgiahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['giahan_id', 'ID_NHANVIEN'], 'required'],
            [['ID_NHANVIEN'], 'integer'],
            [['giahan_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'giahan_id' => 'TEM',
            'ID_NHANVIEN' => 'NHÂN VIÊN',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }

    public function getUrlimage()
    {
        return '/dist/anhgiahan/' . $this->image_url;
    }
}
