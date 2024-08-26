<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chamdiemhocsinh;
/**
 * ChamdiemhocsinhSearch represents the model behind the search form about `app\models\Chamdiemhocsinh`.
 */
class ChamdiemhocsinhSearch extends Chamdiemhocsinh
{
    /**
     * @inheritdoc
     */

    public $TIEUDE;
    public $ID_LOP;

    public function rules()
    {
        return [
            [['TIEUDE', 'DIEM', 'NHAN_XET', 'ID_HOCSINH'], 'safe'],
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


    public function searchdiemtheolop($params, $idlop)
    {
        $query = Chamdiemhocsinh::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('chamdiem');

        // grid filtering conditions
        $query->andFilterWhere([
            'chamdiem.ID_LOP' => $idlop,
        ]);

        $query->andFilterWhere(['like', 'chamdiem.TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['like', 'NHAN_XET', $this->NHAN_XET]);
        $query->andFilterWhere(['=', 'ID_HOCSINH', $this->ID_HOCSINH]);
        $query->orderBy([
            'chamdiem.NGAY_CHAMDIEM' => SORT_DESC,
            'DIEM' => SORT_DESC,
            'ID_HOCSINH' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
