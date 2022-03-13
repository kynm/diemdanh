<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donvi".
 *
 * @property integer $ID_DONVI
 * @property string $MA_DONVI
 * @property string $TEN_DONVI
 * @property string $DIA_CHI
 * @property string $SO_DT
 * @property integer $CAP_TREN
 *
 * @property Daivt[] $daivts
 * @property Donvi $cAPTREN
 * @property Donvi[] $donvis
 * @property Nhanvien[] $nhanviens
 */
class Tt32to78 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'khchuyendoi32to78';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['donvi_id', 'nhanvien_id', 'MST','TEN_KH', 'DIACHI', 'LIENHE', 'EMAIL', 'SDT'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'donvi_id' => 'Địa bàn',
            'nhanvien_id' => 'Nhân viên',
            'MST' => 'Mã số thuế',
            'TEN_KH' => 'Tên công ty',
            'DIACHI' => 'Địa chỉ',
            'LIENHE' => 'Điện thoại',
            'EMAIL' => 'Email',
            'SDT' => 'Số điện thoại',
            'TEN_KETOAN' => 'Tên kế toán',
            'TRANGTHAINANGCAP' => 'Trạng thái nâng cấp',
            'TEN_NV_KD' => 'Tên nhân viên kinh doanh',
            'LOAIHETHONG' => 'Loại hệ thống'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonvi()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'donvi_id']);
    }

    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'nhanvien_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLichsutiepxuc()
    {
        return $this->hasMany(Tiepxuchoadon::className(), ['hddtmoi_id' => 'id']);
    }

    public function getChatid()
    {
        return $this->telegram_id ? $this->telegram_id : '-1001641206920';
    }
}
