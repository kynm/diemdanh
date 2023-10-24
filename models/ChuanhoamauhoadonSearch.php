<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chuanhoamauhoadon;

/**
 * DaivtSearch represents the model behind the search form about `app\models\Daivt`.
 */
class ChuanhoamauhoadonSearch extends Chuanhoamauhoadon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_TB', 'TEN_TB', 'DIACHI_LD', 'MST', 'TEN_NV'], 'safe'],
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
        $query = Chuanhoamauhoadon::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'MA_TB', $this->MA_TB])
            ->andFilterWhere(['like', 'TEN_TB', $this->TEN_TB])
            ->andFilterWhere(['=', 'ketqua', 0])
            ->andFilterWhere(['like', 'DIACHI_LD', $this->DIACHI_LD])
            ->andFilterWhere(['like', 'TEN_NV', $this->TEN_NV])
            ->andFilterWhere(['like', 'MST', $this->MST]);

        return $dataProvider;
    }

    public function searchketqua($params)
    {
        $query = Chuanhoamauhoadon::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['=', 'ketqua', $params['ChuanhoamauhoadonSearch']['ketqua']]);
        $query->andFilterWhere(['like', 'MA_TB', $this->MA_TB])
            ->andFilterWhere(['like', 'TEN_TB', $this->TEN_TB])
            ->andFilterWhere(['like', 'DIACHI_LD', $this->DIACHI_LD])
            ->andFilterWhere(['like', 'TEN_NV', $this->TEN_NV])
            ->andFilterWhere(['like', 'MST', $this->MST]);

        return $dataProvider;
    }
}
