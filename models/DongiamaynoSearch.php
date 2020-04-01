<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dongiamayno;

/**
 * DieuchuyenthietbiSearch represents the model behind the search form of `app\models\Dieuchuyenthietbi`.
 */
class DongiamaynoSearch extends Dieuchuyenthietbi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['ID_NHANVIEN'], 'integer'],
            // [['LOAI_NHIENLIEU'], 'integer'],
            // [['THANG'], 'integer'],
            // [['NAM'], 'integer'],
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
        $query = Dongiamayno::find();

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
            // 'ID_NHANVIEN' => $this->ID_NHANVIEN,
            // 'LOAI_NHIENLIEU' => $this->LOAI_NHIENLIEU,
            // 'THANG' => $this->THANG,
            // 'NAM' => $this->NAM,
        ]);

        return $dataProvider;
    }
}
