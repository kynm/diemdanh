<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dexuatnoidung;
use yii\db\Query;

/**
 * DexuatnoidungSearch represents the model behind the search form about `app\models\Dexuatnoidung`.
 */
class DexuatnoidungSearch extends Dexuatnoidung
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOAITB'], 'integer'],
            [['LAN_BD', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'safe'],
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
        $query = Dexuatnoidung::find();
        $query->addSelect(["ID_LOAITB", "LAN_BD", "CHUKYBAODUONG", 'GROUP_CONCAT(MA_NOIDUNG SEPARATOR "\n") AS MA_NOIDUNG '])
        ->groupBy(["ID_LOAITB", "LAN_BD"])->all();

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
            'ID_LOAITB' => $this->ID_LOAITB,
        ]);

        $query->andFilterWhere(['like', 'LAN_BD', $this->LAN_BD])
            ->andFilterWhere(['like', 'CHUKYBAODUONG', $this->CHUKYBAODUONG])
            ->andFilterWhere(['like', 'MA_NOIDUNG', $this->MA_NOIDUNG]);

        return $dataProvider;
    }
}
