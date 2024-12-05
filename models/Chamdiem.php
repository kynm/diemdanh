<?php

namespace app\models;

use Yii;

class Chamdiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chamdiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NGAY_CHAMDIEM', 'TIEUDE', 'ID_NHANVIEN', 'ID_LOP', 'ID_DONVI'], 'required'],
            [['TIEUDE'], 'string'],
            [['NGAY_CHAMDIEM', 'NOIDUNG'], 'safe'],
            [['ID_LOP', 'ID_NHANVIEN'], 'integer'],
            [['TIEUDE'], 'string', 'max' => 50],
            [['ID_LOP'], 'exist', 'skipOnError' => true, 'targetClass' => Lophoc::className(), 'targetAttribute' => ['ID_LOP' => 'ID_LOP']],
            [['ID_NHANVIEN'], 'exist', 'skipOnError' => true, 'targetClass' => Nhanvien::className(), 'targetAttribute' => ['ID_NHANVIEN' => 'ID_NHANVIEN']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TIEUDE' => 'TIÊU ĐỀ',
            'NGAY_CHAMDIEM' => 'NGÀY CHẤM ĐIỂM',
            'THU' => 'THỨ',
            'ID_LOP' => 'LỚP',
            'GHICHU' => 'GHI CHÚ',
            'HANHDONG' => 'HÀNH ĐỘNG',
            'NOIDUNG' => 'NỘI DUNG',
            'CREATED_AT' => 'NGÀY TẠO',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLop()
    {
        return $this->hasOne(Lophoc::className(), ['ID_LOP' => 'ID_LOP']);
    }

    public function getDonvi()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNhanvien()
    {
        return $this->hasOne(Nhanvien::className(), ['ID_NHANVIEN' => 'ID_NHANVIEN']);
    }


    public function getDschitietchamdiem()
    {
        return $this->hasMany(Chamdiemhocsinh::className(), ['ID_CHAMDIEM' => 'ID']);
    }

    public function getGhichu()
    {
        $dsnhanxet = $this->getDschitietdiemdanh()->andWhere(['is not', 'NHAN_XET', new \yii\db\Expression('null')])->all();
        $text = '';
        foreach ($dsnhanxet as $nhanxet) {
            $text .= '<p>' . $nhanxet->hocsinh->HO_TEN . ' : ' . $nhanxet->NHAN_XET . '</p>';
        }

        return $text;
    }
}
