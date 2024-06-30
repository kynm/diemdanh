<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hocsinh;

/**
 * HocsinhSearch represents the model behind the search form about `app\models\Hocsinh`.
 */
class HocsinhSearch extends Hocsinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_HOCSINH', 'HO_TEN', 'DIA_CHI', 'SO_DT', 'ID_LOP'], 'safe'],
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

    public function searchhocsinhtheodonvi($params)
    {
        $query = Hocsinh::find();

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
            'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'ID_LOP' => SORT_DESC,
            'NGAY_KT' => SORT_ASC,
        ]);

        return $dataProvider;
    }

    public function searchhocsinhtheolop($params, $id)
    {
        $query = Hocsinh::find();

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
            'ID_LOP' => $id,
        ]);

        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        return $dataProvider;
    }
}
