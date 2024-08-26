<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donvi;

/**
 * DonviSearch represents the model behind the search form about `app\models\Donvi`.
 */
class DonviSearch extends Donvi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DONVI'], 'integer'],
            [['MA_DONVI', 'TEN_DONVI', 'DIA_CHI', 'SO_DT', 'STATUS'], 'safe'],
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
        $query = Donvi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 20),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DONVI' => $this->ID_DONVI,
        ]);

        $query->andFilterWhere(['=', 'STATUS', $this->STATUS])
        ->andFilterWhere(['like', 'MA_DONVI', $this->MA_DONVI])
            ->andFilterWhere(['like', 'TEN_DONVI', $this->TEN_DONVI])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'STATUS' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]);
        return $dataProvider;
    }
}
