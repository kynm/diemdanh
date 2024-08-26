<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chamdiem;
/**
 * ChamdiemSearch represents the model behind the search form about `app\models\Chamdiem`.
 */
class ChamdiemSearch extends Chamdiem
{
    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
            [['TIEUDE', 'STATUS', 'ID_LOP'], 'safe'],
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


    public function search($params, $idlop)
    {
        $query = Chamdiem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'chamdiem.TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['=', 'chamdiem.ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['=', 'ID_LOP', $idlop]);
        $query->orderBy([
            'chamdiem.ID_LOP' => SORT_DESC,
            'chamdiem.created_at' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
