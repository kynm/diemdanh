<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ketqua".
 *
 * @property integer $ID_DOTBD
 * @property string $KETQUA
 * @property string $GHICHU
 * @property string $ANH1
 * @property string $ANH2
 * @property string $ANH3
 *
 * @property Dotbaoduong $iDDOTBD
 */
class Ketqua extends \yii\db\ActiveRecord
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
        return 'ketqua';
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
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
            [['GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'string', 'max' => 255],
            [['ID_DOTBD'], 'exist', 'skipOnError' => true, 'targetClass' => Dotbaoduong::className(), 'targetAttribute' => ['ID_DOTBD' => 'ID_DOTBD']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DOTBD' => 'Id  Dotbd',
            'KETQUA' => 'Ketqua',
            'GHICHU' => 'Ghichu',
            'ANH1' => 'Anh1',
            'ANH2' => 'Anh2',
            'ANH3' => 'Anh3',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDOTBD()
    {
        return $this->hasOne(Dotbaoduong::className(), ['ID_DOTBD' => 'ID_DOTBD']);
    }
}
