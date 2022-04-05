<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hotrott32to78;

/**
 * Hotrott32to78Search represents the model behind the search form of `app\models\Hotrott32to78`.
 */
class Hotrott32to78Search extends Hotrott32to78
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tt32to78_id'], 'safe'],
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
        $query = Hotrott32to78::find();

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
        // $query->andFilterWhere(['like', 'activity_type', $this->activity_type])
        //     ->andFilterWhere(['like', 'activity_name', $this->activity_name])
        //     ->andFilterWhere(['like', 'class', $this->class]);

        if (!Yii::$app->user->can('quanly-dulieu')) {
           $query->andFilterWhere(['nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orderBy([
            'ngay_tiepxuc' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function searchBaocaothue($params)
    {
        $query = Hotrott32to78::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('khachhang');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'TEN_KH', $this->tt32to78_id]);
        $query->orderBy([
            'ngay_tiepxuc' => SORT_DESC,
        ]);
        return $dataProvider;
    }
}
