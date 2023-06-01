<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Khachhanggiahan;

/**
 * DotbaoduongSearch represents the model behind the search form about `app\models\Dotbaoduong`.
 */
class KhachhanggiahanSearch extends Khachhanggiahan
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
            [['MST', 'TEN_KH', 'DIACHI', 'LIENHE', 'EMAIL', 'nhanvien_id', 'DICHVU_ID'], 'safe'],
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
        $query = Khachhanggiahan::find();

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
        if (Yii::$app->user->can('nhanvien-hotro-chuyendoi') &&  !Yii::$app->user->can('Administrator')) {
            $query->andFilterWhere(['nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->joinWith('nhanvien');

        $query->andFilterWhere(['in', 'ketqua', [0,1,2,3,4]]);
        $query->andFilterWhere(['like', 'MST', $this->MST]);
        $query->andFilterWhere(['like', 'TEN_KH', $this->TEN_KH]);
        $query->andFilterWhere(['like', 'DIACHI', $this->DIACHI]);
        $query->andFilterWhere(['like', 'LIENHE', $this->LIENHE]);
        $query->andFilterWhere(['like', 'EMAIL', $this->EMAIL]);
        $query->andFilterWhere(['=', 'DICHVU_ID', $this->DICHVU_ID]);
        $query->andFilterWhere(['=', 'nhanvien.ID_NHANVIEN', $this->nhanvien_id]);
        $query->orderBy([
            'NGAY_HH' => SORT_ASC,
        ]);
        return $dataProvider;
    }

    public function searchtrangchu($params)
    {
        $query = Khachhanggiahan::find();

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
        $query->joinWith('nhanvien');

        $query->andFilterWhere(['in', 'ketqua', [0,1,2,3,4]]);
        $query->andFilterWhere(['like', 'MST', $this->MST]);
        $query->andFilterWhere(['like', 'TEN_KH', $this->TEN_KH]);
        $query->andFilterWhere(['like', 'DIACHI', $this->DIACHI]);
        $query->andFilterWhere(['like', 'LIENHE', $this->LIENHE]);
        $query->andFilterWhere(['like', 'EMAIL', $this->EMAIL]);
        if (!Yii::$app->user->can('quanly-dulieu')) {
            $query->andFilterWhere(['=', 'nhanvien.ID_NHANVIEN', $this->nhanvien_id]);
        }
        $query->andFilterWhere(['=', 'DICHVU_ID', $this->DICHVU_ID]);
        $query->orderBy([
            'NGAY_HH' => SORT_ASC,
            'ketqua' => SORT_ASC,
        ]);
        return $dataProvider;
    }

}
