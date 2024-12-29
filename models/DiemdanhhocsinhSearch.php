<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Diemdanhhocsinh;

/**
 * DiemdanhhocsinhSearch represents the model behind the search form about `app\models\Diemdanhhocsinh`.
 */
class DiemdanhhocsinhSearch extends Diemdanhhocsinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOP'], 'integer'],
            [['MA_LOP', 'TEN_LOP', 'DIA_CHI', 'SO_DT', 'ID_DONVI', 'ID_LOP'], 'safe'],
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
    public function searchDiemdanhtheohocsinh($params, $id)
    {
        $query = Diemdanhhocsinh::find();
        // grid filtering conditions
        $query->andFilterWhere([
            'ID_HOCSINH' => $id,
        ]);

        $query->joinWith('diemdanh');
        $query->andFilterWhere(['>=', 'date(quanlydiemdanh.NGAY_DIEMDANH)', $params['TU_NGAY']]);
        $query->andFilterWhere(['<=', 'date(quanlydiemdanh.NGAY_DIEMDANH)', $params['DEN_NGAY']]);

        $query->orderBy([
            'quanlydiemdanh.NGAY_DIEMDANH' => SORT_DESC,
        ]);
        return $query->all();
    }

    public function searchtheodoihocbu($params)
    {
        $query = Diemdanhhocsinh::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->joinWith('diemdanh');
        $this->load($params);
        $query->andFilterWhere([
            'quanlydiemdanh.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
            'STATUS' => 0,
        ]);

        // $query->andFilterWhere(['>=', 'date(quanlydiemdanh.NGAY_DIEMDANH)', $params['TU_NGAY']]);
        $query->andFilterWhere(['=', 'quanlydiemdanh.ID_LOP', $this->ID_LOP]);

        $query->orderBy([
            'quanlydiemdanh.NGAY_DIEMDANH' => SORT_DESC,
            'quanlydiemdanh.ID_LOP' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function searchtheodoihocbutheolop($id, $params)
    {
        $query = Diemdanhhocsinh::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->joinWith('diemdanh');
        $this->load($params);
        $query->andFilterWhere([
            'quanlydiemdanh.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
            'quanlydiemdanh.ID_LOP' => $id,
            'STATUS' => 0,
        ]);

        $query->orderBy([
            'quanlydiemdanh.NGAY_DIEMDANH' => SORT_DESC,
            'quanlydiemdanh.ID_LOP' => SORT_DESC,
        ]);
        return $dataProvider;
    }
}
