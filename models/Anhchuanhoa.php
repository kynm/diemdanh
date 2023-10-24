<?php

namespace app\models;
use Yii;

class Anhchuanhoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anhchuanhoahddt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chuanhoa_id', 'ID_NHANVIEN'], 'required'],
            [['ID_NHANVIEN', 'type'], 'integer'],
            [['chuanhoa_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chuanhoa_id' => 'TEM',
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
        return '/dist/anhchuanhoahddt/' . $this->image_url;
    }
}
