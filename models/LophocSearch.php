<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lophoc;

/**
 * LophocSearch represents the model behind the search form about `app\models\Lophoc`.
 */
class LophocSearch extends Lophoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOP'], 'integer'],
            [['MA_LOP', 'TEN_LOP', 'DIA_CHI', 'SO_DT', 'ID_DONVI'], 'safe'],
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
        $query = Lophoc::find();

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

        $query->joinWith('iDDONVI');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_LOP' => $this->ID_LOP,
            'lophoc.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'MA_LOP', $this->MA_LOP])
            ->andFilterWhere(['like', 'TEN_LOP', $this->TEN_LOP])
            ->andFilterWhere(['like', 'DIA_CHI', $this->DIA_CHI])
            ->andFilterWhere(['like', 'TEN_DONVI', $this->ID_DONVI])
            ->andFilterWhere(['like', 'SO_DT', $this->SO_DT]);

        $query->orderBy([
            'STATUS' => SORT_DESC,
            'TEN_LOP' => SORT_ASC,
        ]);
        return $dataProvider;
    }
}
