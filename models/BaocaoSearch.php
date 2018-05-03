<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Baocao;

/**
 * BaocaoSearch represents the model behind the search form of `app\models\Baocao`.
 */
class BaocaoSearch extends Baocao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD'], 'integer'],
            [['KETQUA', 'GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'safe'],
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
        $query = Baocao::find();

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
            'ID_DOTBD' => $this->ID_DOTBD,
        ]);

        $query->andFilterWhere(['like', 'KETQUA', $this->KETQUA])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'ANH1', $this->ANH1])
            ->andFilterWhere(['like', 'ANH2', $this->ANH2])
            ->andFilterWhere(['like', 'ANH3', $this->ANH3]);

        return $dataProvider;
    }
}
