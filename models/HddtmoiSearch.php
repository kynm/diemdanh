<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hddtmoi;

/**
 * DotbaoduongSearch represents the model behind the search form about `app\models\Dotbaoduong`.
 */
class HddtmoiSearch extends Hddtmoi
{
     // Virtual variable
    public $ID_DAI;
    public $ID_DONVI;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['ID_DOTBD', 'ID_DAI', 'ID_DONVI'], 'integer'],
            // [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['MST', 'TEN_KH', 'DIACHI', 'LIENHE', 'EMAIL'], 'safe'],
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
        $query = Hddtmoi::find();

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

        $query->andFilterWhere(['like', 'baohong.MST', $this->MST]);
        $query->andFilterWhere(['like', 'baohong.TEN_KH', $this->TEN_KH]);
        $query->andFilterWhere(['like', 'baohong.DIACHI', $this->DIACHI]);
        $query->andFilterWhere(['like', 'baohong.LIENHE', $this->LIENHE]);
        $query->andFilterWhere(['like', 'baohong.EMAIL', $this->EMAIL]);
        $query->orderBy([
            'ngay_lh' => SORT_ASC,
        ]);
        return $dataProvider;
    }

}
