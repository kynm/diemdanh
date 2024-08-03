<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donhang;

/**
 * DonhangSearch represents the model behind the search form about `app\models\Donhang`.
 */
class DonhangSearch extends Donhang
{
    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
            [['ID_DONVI', 'STATUS'], 'safe'],
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


    public function search($params)
    {
        $query = Donhang::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'ID_DONVI', $this->ID_DONVI]);
        $query->andFilterWhere(['=', 'STATUS', $this->STATUS]);
        $query->orderBy([
            'STATUS' => SORT_ASC,
        ]);

        return $dataProvider;
    }
}
