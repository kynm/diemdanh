<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "tramvt".
 *
 * @property int $ID_TRAM
 * @property string $MA_TRAM
 * @property string $TEN_TRAM
 * @property string $DIADIEM
 * @property string $NGAY_KTNT
 * @property string $KINH_DO
 * @property string $VI_DO
 * @property int $ID_DAI
 * @property string $ID_NHANVIEN
 * @property int $LOAITRAM
 *
 * @property Dotbaoduong[] $dotbaoduongs
 */
class TypePayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_payments';
    }
}
