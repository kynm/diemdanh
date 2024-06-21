<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nhanvien".
 *
 * @property string $ID_NHANVIEN
 * @property string $MA_NHANVIEN
 * @property string $TEN_NHANVIEN
 * @property string $CHUC_VU
 * @property string $DIEN_THOAI
 * @property integer $ID_DONVI
 * @property integer $ID_LOP
 * @property string $GHI_CHU
 * @property string $USER_NAME
 *
 * @property Dotbaoduong[] $dotbaoduongs
 * @property Kehoachbdtb[] $kehoachbdtbs
 * @property Daivt $iDDAI
 * @property Donvi $iDDONVI
 * @property Thuchienbd[] $thuchienbds
 * @property Tramvt[] $tramvts
 */
class Nhanvien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhanvien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TEN_NHANVIEN', 'ID_DONVI'], 'required'],
            [['CHUC_VU', 'ID_DONVI'], 'integer'],
            [['MA_NHANVIEN'], 'string', 'max' => 20],
            [['TEN_NHANVIEN'], 'string', 'max' => 100],
            [['USER_NAME'], 'string', 'max' => 50],
            [['DIEN_THOAI'], 'string', 'max' => 15],
            [['GHI_CHU'], 'string', 'max' => 200],
            [['ID_LOP', 'DIEN_THOAI'], 'safe'],
            [['USER_NAME'], 'unique'],
            [['ID_LOP'], 'exist', 'skipOnError' => true, 'targetClass' => Lophoc::className(), 'targetAttribute' => ['ID_LOP' => 'ID_LOP']],
            [['ID_DONVI'], 'exist', 'skipOnError' => true, 'targetClass' => Donvi::className(), 'targetAttribute' => ['ID_DONVI' => 'ID_DONVI']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_NHANVIEN' => 'ID Nhân viên',
            'MA_NHANVIEN' => 'Mã cá nhân',
            'TEN_NHANVIEN' => 'Họ và tên',
            'CHUC_VU' => 'Chức vụ',
            'DIEN_THOAI' => 'Điện thoại',
            'ID_DONVI' => 'Đơn vị',
            'ID_LOP' => 'Đài',
            'GHI_CHU' => 'Ghi chú',
            'USER_NAME' => 'User  Name',
        ];
    }

    /**
     * @return email (string)
     */
    public function makeEmail($name)
    {
        $suffix = ".@diemdanh.online";
        $words = explode(" ", $name);
        $email = end($words);
        for ($i=0; $i < sizeof($words) - 1; $i++) { 
            $email = $email . $words[$i][0];
        }
        $email = $email . $suffix;
        return $email;
    }

    function stripUnicode($str){
        if(!$str) return false;
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
            'E'=>'È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
            'I'=>'Ì|Í|Ị|Ỉ|Ĩ',
            'O'=>'Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ',
            'U'=>'Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
            'Y'=>'Ỳ|Ý|Ỵ|Ỷ|Ỹ',
            'D'=>'Đ',
        );
        foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
        
        return strtolower($str);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'USER_NAME']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDONVI()
    {
        return $this->hasOne(Donvi::className(), ['ID_DONVI' => 'ID_DONVI']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChucvu()
    {
        return $this->hasOne(Chucvu::className(), ['id' => 'CHUC_VU']);
    }
}
