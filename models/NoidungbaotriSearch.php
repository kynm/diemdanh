<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Noidungbaotri;

/**
 * NoidungbaotriSearch represents the model behind the search form about `app\models\Noidungbaotri`.
 */
class NoidungbaotriSearch extends Noidungbaotri
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_NOIDUNG', 'NOIDUNG'], 'safe'],
            [['ID_THIETBI'], 'integer'],
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
        $query = Noidungbaotri::find();

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
        ]);

        $query->andFilterWhere(['like', 'MA_NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'NOIDUNG', $this->NOIDUNG]);

        return $dataProvider;
    }
}
