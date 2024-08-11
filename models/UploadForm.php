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
    public $ID_DAI;
    public $ID_DONVI;

    public function rules()
    {
        return [
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
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
        ];
    }
}
 ?>