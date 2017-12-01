<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Thietbitram;

/**
 * ThietbitramSearch represents the model behind the search form about `app\models\Thietbitram`.
 */
class ThietbitramSearch extends Thietbitram
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_THIETBI', 'ID_LOAITB', 'ID_TRAM', 'LANBD'], 'integer'],
            [['SERIAL_MAC', 'NGAYSX', 'NGAYSD', 'LANBAODUONGTRUOC', 'LANBAODUONGTIEP'], 'safe'],
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
        $query = Thietbitram::find();

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
            'ID_THIETBI' => $this->ID_THIETBI,
            'ID_LOAITB' => $this->ID_LOAITB,
            'ID_TRAM' => $this->ID_TRAM,
            'NGAYSX' => $this->NGAYSX,
            'NGAYSD' => $this->NGAYSD,
            'LANBD' => $this->LANBD,
            'LANBAODUONGTRUOC' => $this->LANBAODUONGTRUOC,
            'LANBAODUONGTIEP' => $this->LANBAODUONGTIEP,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_MAC', $this->SERIAL_MAC]);

        return $dataProvider;
    }
}
