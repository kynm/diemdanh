<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quanlydiemdanh;

/**
 * QuanlydiemdanhSearch represents the model behind the search form about `app\models\Quanlydiemdanh`.
 */
class QuanlydiemdanhSearch extends Quanlydiemdanh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TIEUDE', 'ID_LOP'], 'safe'],
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
    public function searchDiemdanhtheolop($params, $id)
    {
        $query = Quanlydiemdanh::find();
        $query->andFilterWhere([
            'ID_LOP' => $id,
        ]);
        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['like', 'TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['>=', 'date(quanlydiemdanh.NGAY_DIEMDANH)', $params['TU_NGAY']]);
        $query->andFilterWhere(['<=', 'date(quanlydiemdanh.NGAY_DIEMDANH)', $params['DEN_NGAY']]);
        $query->orderBy([
            'NGAY_DIEMDANH' => SORT_DESC,
        ]);

        return $query->all();
    }

    public function searchdiemdanhtheodonvi($params)
    {
        $query = Quanlydiemdanh::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);
        $query->andFilterWhere(['like', 'TIEUDE', $this->TIEUDE]);
        $query->orderBy([
            'NGAY_DIEMDANH' => SORT_DESC,
            'ID_LOP' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
