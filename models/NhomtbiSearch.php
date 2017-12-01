<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nhomtbi;

/**
 * NhomtbiSearch represents the model behind the search form about `app\models\Nhomtbi`.
 */
class NhomtbiSearch extends Nhomtbi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHOM'], 'integer'],
            [['MA_NHOM', 'TEN_NHOM'], 'safe'],
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
        $query = Nhomtbi::find();

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
            'ID_NHOM' => $this->ID_NHOM,
        ]);

        $query->andFilterWhere(['like', 'MA_NHOM', $this->MA_NHOM])
            ->andFilterWhere(['like', 'TEN_NHOM', $this->TEN_NHOM]);

        return $dataProvider;
    }
}
