<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chukybaoduong".
 *
 * @property string $alias
 * @property string $value
 */
class Chukybaoduong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chukybaoduong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'value'], 'required'],
            [['alias', 'value'], 'string', 'max' => 32],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alias' => 'Alias',
            'value' => 'Value',
        ];
    }
}
