<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "baocao".
 *
 * @property int $ID_DOTBD
 * @property string $KETQUA
 * @property string $GHICHU
 * @property string $ANH1
 * @property string $ANH2
 * @property string $ANH3
 *
 * @property Dotbaoduong $dOTBD
 */
class Baocao extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $files;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baocao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'KETQUA'], 'required'],
            [['ID_DOTBD'], 'integer'],
            [['KETQUA'], 'string', 'max' => 32],
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 3],
            [['GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'string', 'max' => 255],
            [['ID_DOTBD'], 'unique'],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Đợt bảo dưỡng',
            'KETQUA' => 'Kết quả',
            'GHICHU' => 'Ghi chú',
            'ANH1' => 'Ảnh 1',
            'ANH2' => 'Ảnh 2',
            'ANH3' => 'Ảnh 3',
            'files' => 'Upload ảnh',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOTBD()
    {
        return $this->hasOne(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }
}
