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
    public $THANG;
    public $NAM;
    public $MA_DONVIKT;

    public function rules()
    {
        return [
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
            [['THANG', 'NAM', 'MA_DONVIKT'], 'required'],
            [['THANG', 'NAM', 'MA_DONVIKT'], 'integer'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            // $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'THANG' => 'Tháng',
            'NAM' => 'Năm',
            'MA_DONVIKT' => 'Đơn vị',
        ];
    }
}
 ?>