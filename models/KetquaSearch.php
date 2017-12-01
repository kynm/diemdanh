<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ketqua;

/**
 * KetquaSearch represents the model behind the search form about `app\models\Ketqua`.
 */
class KetquaSearch extends Ketqua
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'KETQUA', 'ID_NHANVIEN'], 'integer'],
            [['GHICHU', 'ANH1', 'ANH2', 'ANH3'], 'safe'],
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
        $query = Ketqua::find();

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
            'ID_THIETBI' => $this->ID_THIETBI,
            'KETQUA' => $this->KETQUA,
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
        ]);

        $query->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'ANH1', $this->ANH1])
            ->andFilterWhere(['like', 'ANH2', $this->ANH2])
            ->andFilterWhere(['like', 'ANH3', $this->ANH3]);

        return $dataProvider;
    }
}
