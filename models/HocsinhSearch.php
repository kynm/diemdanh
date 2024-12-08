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
            [['MA_HOCSINH', 'HO_TEN', 'DIA_CHI', 'SO_DT', 'ID_LOP', 'STATUS', 'HT_HP'], 'safe'],
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

        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['=', 'HT_HP', $this->HT_HP]);
        $query->andFilterWhere(['=', 'STATUS', isset($params['HocsinhSearch']['STATUS']) ? $this->STATUS : 1]);
        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'STATUS' => SORT_DESC,
            'HO_TEN' => SORT_ASC,
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

        $query->orderBy([
            'STATUS' => SORT_DESC,
            'HO_TEN' => SORT_ASC,
        ]);

        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['=', 'STATUS', isset($this->STATUS) ? $this->STATUS : 1])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        return $dataProvider;
    }

    public function searchhocsinhhethantheongay($params)
    {
        $query = Hocsinh::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['in', 'HT_HP', [0,3]]);
        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'DATEDIFF(NGAY_KT, NOW())' => SORT_ASC,
            'STATUS' => SORT_DESC,
            'HO_TEN' => SORT_ASC,
        ]);

        return $dataProvider;
    }

    public function searchhocsinhhetheosobuoihoc($params)
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

        $query->andFilterWhere(['<>', 'SOBH_DAMUA', 0]);
        $query->andFilterWhere(['is', 'NGAY_KT', new \yii\db\Expression('null')]);
        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['like', 'MA_HOCSINH', $this->MA_HOCSINH])
            ->andFilterWhere(['like', 'HO_TEN', $this->HO_TEN])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'STATUS' => SORT_DESC,
            'HO_TEN' => SORT_ASC,
        ]);

        return $dataProvider;
    }
}
