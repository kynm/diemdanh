<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ThietbiIOC;

/**
 * ThietbiSearch represents the model behind the search form about `app\models\Thietbi`.
 */
class IOCSearch extends ThietbiIOC
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_TRAM'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function danhsachthietbi($params)
    {
        if (isset($params['ID_THIETBI']) && $params['ID_THIETBI']) {
            $sqltonghop = "SELECT tb.system, tb.KINHDO,tb.VIDO from ioc_thietbi tb where  ID_THIETBI= " . $params['ID_THIETBI'];
        } else {
            $sqltonghop = "SELECT tb.system, tb.KINHDO,tb.VIDO from ioc_thietbi tb";
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function danhsachspliter($params)
    {
        if (isset($params['ID_THIETBI']) && $params['ID_THIETBI']) {
            $sqltonghop = "SELECT spl.KETCUOI_ID,spl.TEN_KC,spl.KINHDO,spl.VIDO FROM ioc_spliter spl where spl.ID_THIETBI = " . $params['ID_THIETBI'];
        } else {
            $sqltonghop = "SELECT spl.KETCUOI_ID,spl.TEN_KC,spl.KINHDO,spl.VIDO FROM ioc_spliter spl LIMIT 500";
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function laythongtinspliter($params)
    {
        $sqltonghop = "SELECT spl.KETCUOI_ID,spl.TEN_KC,spl.KINHDO,spl.VIDO FROM ioc_spliter spl WHERE KETCUOI_ID=" . $params['KETCUOI_ID'] . ' LIMIT 1';

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function danhsachthuebao($params)
    {
        $sqltonghop = "SELECT tb.ma_tb,tb.KINHDO,tb.VIDO,(CASE WHEN tb.NHAMANG = 1 THEN 'black' WHEN tb.NHAMANG = 2 THEN 'blue' WHEN tb.NHAMANG = 3 THEN 'red' WHEN tb.NHAMANG = 4 THEN 'yellow' END) color FROM ioc_thuebao tb WHERE tb.KINHDO is not null and tb.KINHDO <> 0 ";
        if ($params['KETCUOI_ID']) {
            $sqltonghop .= " AND tb.KETCUOI_ID = " . $params['KETCUOI_ID'];
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function baocaodanhsachthuebao($params)
    {
        $sqltonghop = "SELECT a.KINHDO KINHDO_SPL,a.VIDO VIDO_SPL,tb.ma_tb,tb.KINHDO KINHDO_TB,tb.VIDO VIDO_TB, ROUND(tb.KHOANG_CACH, 2) KHOANG_CACH FROM ioc_spliter a, ioc_thuebao tb where a.ketcuoi_id = tb.KETCUOI_ID and tb.KINHDO is not null and tb.KINHDO <> 0 ";
        if ($params['KETCUOI_ID']) {
            $sqltonghop .= "AND tb.KETCUOI_ID = " . $params['KETCUOI_ID'];
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function thiphanthuebao()
    {
        $sqltonghop = "SELECT (CASE WHEN tb.NHAMANG = 1 THEN 'Vietel' WHEN tb.NHAMANG = 2 THEN 'VNPT' WHEN tb.NHAMANG = 3 THEN 'FPT' WHEN tb.NHAMANG = 4 THEN 'Chưa sử dụng' END) NHAMANG, count(*) SO_LUONG FROM `ioc_thuebao` tb GROUP by NHAMANG";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tongsothuebao()
    {
        $sqltonghop = "select count(*) SO_LUONG FROM `ioc_thuebao` tb";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }
}
