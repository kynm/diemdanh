<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tt32to78;

/**
 * DotbaoduongSearch represents the model behind the search form about `app\models\Dotbaoduong`.
 */
class Tt32to78Search extends Tt32to78
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
            [['MST', 'TEN_KH', 'DIACHI', 'LIENHE', 'EMAIL', 'TRANGTHAINANGCAP', 'nhanvien_id'], 'safe'],
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
        $query = Tt32to78::find();

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
        if (Yii::$app->user->can('nhanvien-hotro-chuyendoi')) {
            $query->andFilterWhere(['nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->andFilterWhere(['not in', 'ketqua', [4,5,6,7,8,9]]);
        $query->andFilterWhere(['like', 'MST', $this->MST]);
        $query->andFilterWhere(['like', 'TEN_KH', $this->TEN_KH]);
        $query->andFilterWhere(['like', 'DIACHI', $this->DIACHI]);
        $query->andFilterWhere(['like', 'LIENHE', $this->LIENHE]);
        $query->andFilterWhere(['like', 'EMAIL', $this->EMAIL]);
        $query->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->nhanvien_id]);
        $query->andFilterWhere(['=', 'TRANGTHAINANGCAP', $this->TRANGTHAINANGCAP]);
        $query->orderBy([
            'ngay_lh' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function searchBaocaothue($params)
    {
        $query = Tt32to78::find();

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
        $query->andFilterWhere(['not in', 'ketqua', [4,5,6,7,8,9]]);
        $query->andFilterWhere(['like', 'MST', $this->MST]);
        $query->andFilterWhere(['like', 'TEN_KH', $this->TEN_KH]);
        $query->andFilterWhere(['like', 'DIACHI', $this->DIACHI]);
        $query->andFilterWhere(['like', 'LIENHE', $this->LIENHE]);
        $query->andFilterWhere(['like', 'EMAIL', $this->EMAIL]);
        $query->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->nhanvien_id]);
        $query->andFilterWhere(['=', 'TRANGTHAINANGCAP', $this->TRANGTHAINANGCAP]);
        $query->orderBy([
            'ngay_lh' => SORT_DESC,
        ]);
        return $dataProvider;
    }

}
