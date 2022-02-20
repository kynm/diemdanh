<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Baohong;

/**
 * BaohongSearch represents the model behind the search form about `app\models\Baohong`.
 */
class BaohongSearch extends Baohong
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nhanvien_xl_id'], 'integer'],
            [['ten_kh', 'diachi', 'so_dt'], 'safe'],
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
        $query = Baohong::find();

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

        $query->joinWith('iDDONVI');
        $query->joinWith('iDDAI');

        // // grid filtering conditions
        // $query->andFilterWhere([
        //     'ID_NHANVIEN' => $this->ID_NHANVIEN,
        // ]);

        // $query->andFilterWhere(['like', 'MA_NHANVIEN', $this->MA_NHANVIEN])
        //     ->andFilterWhere(['like', 'TEN_NHANVIEN', $this->TEN_NHANVIEN])
        //     ->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI])
        //     ->andFilterWhere(['like', 'daivt.TEN_DAIVT', $this->ID_DAI])
        //     ->andFilterWhere(['like', 'CHUC_VU', $this->ten_kh])
        //     ->andFilterWhere(['like', 'DIEN_THOAI', $this->DIEN_THOAI])
        //     ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
        //     ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME]);

        return $dataProvider;
    }
}
