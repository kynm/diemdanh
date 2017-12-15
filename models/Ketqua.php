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
 */
class Ketqua extends \yii\db\ActiveRecord
{
    /*variable*/
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
            [['files'], 'file', 'extensions' => 'png, jpg, PNG, JPG', 'maxFiles' => 3, 'maxSize' => 4000 * 3000 * 25],
            [['KETQUA'], 'string', 'max' => 32],
            [['GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'string', 'max' => 255],
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
}
