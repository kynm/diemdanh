<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivitiesLog;

/**
 * ActivitiesLogSearch represents the model behind the search form of `app\models\ActivitiesLog`.
 */
class ActivitiesLogSearch extends ActivitiesLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_log_id', 'user_id', 'create_at'], 'integer'],
            [['activity_type', 'description'], 'safe'],
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
        $query = ActivitiesLog::find()->orderBy(['create_at' => SORT_DESC]);

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
            'activity_log_id' => $this->activity_log_id,
            'user_id' => $this->user_id,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'activity_type', $this->activity_type])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
