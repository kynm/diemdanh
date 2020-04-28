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

    public function rules()
    {
        return [
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
            [['THANG', 'NAM'], 'required'],
            [['THANG', 'NAM'], 'integer'],

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
}
 ?>