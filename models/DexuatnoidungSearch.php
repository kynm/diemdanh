<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dexuatnoidung;

/**
 * DexuatnoidungSearch represents the model behind the search form of `app\models\Dexuatnoidung`.
 */
class DexuatnoidungSearch extends Dexuatnoidung
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_NOIDUNG', 'ID_LOAITB', 'CHUKYBAODUONG'], 'safe'],
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
        $query = Dexuatnoidung::find()->where(['ID_LOAITB' => $params['id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 10, 
                // 'pageParam' => 'dexuatnoidung-page-param' 
            ],
            // 'sort' => [
            //     'sortParam' => 'dexuatnoidung-sort-param',
            // ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_LOAITB' => $this->ID_LOAITB,
            'CHUKYBAODUONG' => $this->CHUKYBAODUONG,
        ]);

        $query->andFilterWhere(['like', 'MA_NOIDUNG', $this->MA_NOIDUNG]);

        return $dataProvider;
    }
}
