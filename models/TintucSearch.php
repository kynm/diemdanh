<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tintuc;

/**
 * QuanlyphuhuynhSearch represents the model behind the search form about `app\models\Tintuc`.
 */
class TintucSearch extends Tintuc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TITLE',  'CONTENT', 'STATUS'], 'safe'],
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
    public function searchtintuctheodonvi($params)
    {
        $query = Tintuc::find();

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
            'donvi.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'TITLE', $this->TITLE])
            ->andFilterWhere(['like', 'CONTENT', $this->CONTENT])
            ->andFilterWhere(['=', 'STATUS', $this->STATUS]);

        return $dataProvider;
    }
}
