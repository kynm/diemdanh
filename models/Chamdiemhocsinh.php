<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chucvu".
 *
 * @property int $id
 * @property string $ten_chucvu
 * @property int $cap
 *
 * @property Nhanvien[] $nhanviens
 */
class Chamdiemhocsinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chamdiemhocsinh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN', 'ID_LOP', 'ID_HOCSINH', 'ID_CHAMDIEM'], 'required'],
            [['NHAN_XET'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'DIEM' => 'ĐIỂM',
            'NGHE' => 'NGHE',
            'NOI' => 'NÓI',
            'DOC' => 'ĐỌC',
            'VIET' => 'VIẾT',
            'ID_HOCSINH' => 'HỌC SINH',
            'ID_LOP' => 'LỚP',
            'NHAN_XET' => 'GHI CHÚ',
            'NGAY_CHAMDIEM' => 'NGÀY KIỂM TRA',
            'TIEUDE' => 'BÀI KIỂM TRA',
        ];
    }

    public function getChamdiem()
    {
        return $this->hasOne(Chamdiem::className(), ['ID' => 'ID_CHAMDIEM']);
    }

    public function getHocsinh()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_HOCSINH']);
    }

    public function getLop()
    {
        return $this->hasOne(Hocsinh::className(), ['ID' => 'ID_LOP']);
    }
}
