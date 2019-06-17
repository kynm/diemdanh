<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_kiemtranhatram".
 *
 * @property int $id
 * @property int $id_tram
 * @property int $so_ngay
 * @property int $sms
 * @property int $id_nhanvien
 */
class LogKiemtranhatram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_kiemtranhatram';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tram', 'so_ngay', 'sms', 'id_nhanvien'], 'required'],
            [['id_tram', 'so_ngay', 'id_nhanvien'], 'integer'],
            [['sms'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tram' => 'Tên trạm',
            'so_ngay' => 'Số ngày trễ',
            'sms' => 'Sms',
            'id_nhanvien' => 'Nhân viên',
            'loai_tram' => 'Loại trạm',
            'created_at' => 'Thời gian'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRAMVT()
    {
        return $this->hasOne(Tramvt::className(), ['ID_TRAM' => 'id_tram']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNHANVIEN()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'id_nhanvien']);
    }

    public function makeNotiLog($id_tram, $so_ngay, $id_nhanvien)
    {
        $model = new LogKiemtranhatram;
        $model->id_tram = $id_tram;
        $model->so_ngay = $so_ngay;
        $model->id_nhanvien = $id_nhanvien;
        $model->sms = "0";
        $model->created_at = strtotime("yesterday");
        $model->save();
    }

    public function makeWarningLog($id_tram, $so_ngay, $id_nhanvien)
    {
        $model = new LogKiemtranhatram;
        $model->id_tram = $id_tram;
        $model->so_ngay = $so_ngay;
        $model->id_nhanvien = $id_nhanvien;
        $model->sms = "1";
        $model->created_at = time();
        $model->save();
    }
}
