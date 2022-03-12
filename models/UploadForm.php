<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $fileupload;
    public $nhanvien_id;
    public $donvi_id;

    public function rules()
    {
        return [
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
            [['nhanvien_id', 'donvi_id'], 'required'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'nhanvien_id' => 'Nhân viên',
            'donvi_id' => 'Đơn vị',
        ];
    }
}
 ?>