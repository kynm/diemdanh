<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kehoachbdtb;
use app\models\Dotbaoduong;

/**
 * KehoachbdtbSearch represents the model behind the search form about `app\models\Kehoachbdtb`.
 */
class KehoachbdtbSearch extends Kehoachbdtb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['MA_NOIDUNG'], 'safe'],
        ];
    }
    // , 'MA_DOTBD', 'ID_TRAMVT', 'TRUONG_NHOM'
    // , 'TRANGTHAI'
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
        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kế hoạch']);

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
        // $query->andFilterWhere([
        //     'MA_DOTBD' => $this->MA_DOTBD,
        //     'ID_TRAMVT' => $this->ID_TRAMVT,
        //     'TRUONG_NHOM' => $this->TRUONG_NHOM,
        // ]);

        // $query->andFilterWhere(['like', 'TRANGTHAI', $this->TRANGTHAI]);

        return $dataProvider;
    }

    public function searchND($params)
    {
        $query = Kehoachbdtb::find()->where(['ID_DOTBD' => $params['id']]);

        // add conditions that should always apply here
        // print_r($params);
        // die;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
