<?php

namespace app\models;

use Yii;
use Empathy\Validators\DateTimeCompareValidator;


class IOCThuebao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ioc_thuebao';
    }
}
