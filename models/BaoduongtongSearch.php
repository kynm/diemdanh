<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Baoduongtong;

/**
 * BaoduongtongSearch represents the model behind the search form of `app\models\Baoduongtong`.
 */
class BaoduongtongSearch extends Baoduongtong
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_BDT', 'TYPE', 'ID_NHANVIEN'], 'integer'],
            [['MA_BDT', 'MO_TA', 'TRANGTHAI'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Baoduongtong::find();

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
            'ID_BDT' => $this->ID_BDT,
            'TYPE' => $this->TYPE,
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
        ]);

        $query->andFilterWhere(['like', 'MA_BDT', $this->MA_BDT])
            ->andFilterWhere(['like', 'MO_TA', $this->MO_TA])
            ->andFilterWhere(['like', 'TRANGTHAI', $this->TRANGTHAI]);

        return $dataProvider;
    }
}
