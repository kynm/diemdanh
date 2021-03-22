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

    public function danhsachthietbi()
    {
        $sqltonghop = "SELECT dv.tram,tb.system, tb.KINHDO,tb.VIDO from ioc_donvitram dv, ioc_thietbi tb where dv.ID_TRAM = tb.ID_TRAM";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function danhsachspliter()
    {
        $sqltonghop = "SELECT spl.TEN_KC,spl.KINHDO,spl.VIDO FROM ioc_spliter spl";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function danhsachthuebao()
    {
        $sqltonghop = "SELECT tb.ma_tb,tb.KINHDO,tb.VIDO,(CASE WHEN tb.NHAMANG = 1 THEN 'black' WHEN tb.NHAMANG = 2 THEN 'blue' WHEN tb.NHAMANG = 3 THEN 'red' WHEN tb.NHAMANG = 4 THEN 'yellow' END) color FROM ioc_thuebao tb WHERE tb.KINHDO is not null and tb.KINHDO <> 0 and tb.phuong_id = 6176
";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }
}
