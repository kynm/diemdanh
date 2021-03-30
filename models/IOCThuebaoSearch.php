<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IOCThuebao;

/**
 * DieuchuyenthietbiSearch represents the model behind the search form of `app\models\Dieuchuyenthietbi`.
 */
class IOCThuebaoSearch extends IOCThuebao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['ID', 'ID_THIETBI', 'ID_TRAM_NGUON', 'ID_TRAM_DICH'], 'integer'],
            // [['NGAY_CHUYEN', 'LY_DO'], 'safe'],
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
        $query = IOCThuebao::find();

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
        $query->joinWith('spliter');
        // grid filtering conditions
        if (isset($params['KETCUOI_ID'])) {
            $query->andFilterWhere([
                'ioc_thuebao.KETCUOI_ID' => $params['KETCUOI_ID'],
            ]);
        }

        if (isset($params['ID_THIETBI'])) {
            $query->andFilterWhere([
                'ioc_spliter.ID_THIETBI' => $params['ID_THIETBI'],
            ]);
        }

        return $dataProvider;
    }
}
