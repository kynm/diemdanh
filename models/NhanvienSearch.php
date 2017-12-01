<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nhanvien;

/**
 * NhanvienSearch represents the model behind the search form about `app\models\Nhanvien`.
 */
class NhanvienSearch extends Nhanvien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN', 'ID_DONVI', 'ID_DAI'], 'integer'],
            [['MA_NHANVIEN', 'TEN_NHANVIEN', 'CHUC_VU', 'DIEN_THOAI', 'GHI_CHU', 'USER_NAME'], 'safe'],
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
        $query = Nhanvien::find();

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
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
            'ID_DONVI' => $this->ID_DONVI,
            'ID_DAI' => $this->ID_DAI,
        ]);

        $query->andFilterWhere(['like', 'MA_NHANVIEN', $this->MA_NHANVIEN])
            ->andFilterWhere(['like', 'TEN_NHANVIEN', $this->TEN_NHANVIEN])
            ->andFilterWhere(['like', 'CHUC_VU', $this->CHUC_VU])
            ->andFilterWhere(['like', 'DIEN_THOAI', $this->DIEN_THOAI])
            ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
            ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME]);

        return $dataProvider;
    }
}
