<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Daivt;

/**
 * DaivtSearch represents the model behind the search form about `app\models\Daivt`.
 */
class DaivtSearch extends Daivt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DAI', 'ID_DONVI'], 'integer'],
            [['MA_DAIVT', 'TEN_DAIVT', 'DIA_CHI', 'SO_DT'], 'safe'],
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
        $query = Daivt::find();

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
            'ID_DAI' => $this->ID_DAI,
            'ID_DONVI' => $this->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'MA_DAIVT', $this->MA_DAIVT])
            ->andFilterWhere(['like', 'TEN_DAIVT', $this->TEN_DAIVT])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        return $dataProvider;
    }
}
