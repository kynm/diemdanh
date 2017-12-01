<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tramvt;

/**
 * TramvtSearch represents the model behind the search form about `app\models\Tramvt`.
 */
class TramvtSearch extends Tramvt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_TRAM', 'ID_DAIVT', 'ID_NHANVIEN'], 'integer'],
            [['MA_TRAM', 'DIADIEM'], 'safe'],
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
        $query = Tramvt::find();

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
            'ID_TRAM' => $this->ID_TRAM,
            'ID_DAIVT' => $this->ID_DAIVT,
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
        ]);

        $query->andFilterWhere(['like', 'MA_TRAM', $this->MA_TRAM])
            ->andFilterWhere(['like', 'DIADIEM', $this->DIADIEM]);

        return $dataProvider;
    }
}
