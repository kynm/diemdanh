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
            [['ID_THIETBI', 'LANBD'], 'integer'],
            [['SERIAL_MAC', 'NGAYSX', 'NGAYSD', 'LANBAODUONGTRUOC', 'LANBAODUONGTIEP', 'ID_LOAITB', 'ID_TRAM'], 'safe'],
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

        $query->joinWith('iDLOAITB');
        $query->joinWith('iDTRAM');

        // grid filtering conditions
        $query->andFilterWhere([
            'NGAYSX' => $this->NGAYSX,
            'NGAYSD' => $this->NGAYSD,
            'LANBD' => $this->LANBD,
            'LANBAODUONGTRUOC' => $this->LANBAODUONGTRUOC,
            'LANBAODUONGTIEP' => $this->LANBAODUONGTIEP,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_MAC', $this->SERIAL_MAC])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_LOAITB]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchTram($params)
    {
        $query = Thietbitram::find()->where(['thietbitram.ID_TRAM' => $params['id']]);

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

        $query->joinWith('iDLOAITB');
        $query->joinWith('iDTRAM');

        // grid filtering conditions
        $query->andFilterWhere([
            'NGAYSX' => $this->NGAYSX,
            'NGAYSD' => $this->NGAYSD,
            'LANBD' => $this->LANBD,
            'LANBAODUONGTRUOC' => $this->LANBAODUONGTRUOC,
            'LANBAODUONGTIEP' => $this->LANBAODUONGTIEP,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_MAC', $this->SERIAL_MAC])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_LOAITB]);

        return $dataProvider;
    }
}
