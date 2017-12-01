<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Thietbi;

/**
 * ThietbiSearch represents the model behind the search form about `app\models\Thietbi`.
 */
class ThietbiSearch extends Thietbi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_THIETBI', 'ID_NHOMTB'], 'integer'],
            [['MA_THIETBI', 'TEN_THIETBI', 'HANGSX', 'THONGSOKT', 'PHUKIEN'], 'safe'],
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
    public function search($params)
    {
        $query = Thietbi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_THIETBI' => $this->ID_THIETBI,
            'ID_NHOMTB' => $this->ID_NHOMTB,
        ]);

        $query->andFilterWhere(['like', 'MA_THIETBI', $this->MA_THIETBI])
            ->andFilterWhere(['like', 'TEN_THIETBI', $this->TEN_THIETBI])
            ->andFilterWhere(['like', 'HANGSX', $this->HANGSX])
            ->andFilterWhere(['like', 'THONGSOKT', $this->THONGSOKT])
            ->andFilterWhere(['like', 'PHUKIEN', $this->PHUKIEN]);

        return $dataProvider;
    }
}
