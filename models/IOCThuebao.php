<?php

namespace app\models;

use Yii;
use Empathy\Validators\DateTimeCompareValidator;
use app\models\IOCSpliter;

class IOCThuebao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ioc_thuebao';
    }

    public function getSpliter()
    {
        return $this->hasOne(IOCSpliter::className(), ['KETCUOI_ID' => 'KETCUOI_ID']);
    }
}
