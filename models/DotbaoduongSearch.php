<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dotbaoduong;
use app\models\Kehoachbdtb;

/**
 * DotbaoduongSearch represents the model behind the search form about `app\models\Dotbaoduong`.
 */
class DotbaoduongSearch extends Dotbaoduong
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_TRAMVT', 'TRUONG_NHOM'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['MA_DOTBD', 'NGAY_BD'], 'safe'],
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
        $query = Dotbaoduong::find();

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
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'ID_TRAMVT' => $this->ID_TRAMVT,
            'TRUONG_NHOM' => $this->TRUONG_NHOM,
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD]);

        return $dataProvider;
    }


}
