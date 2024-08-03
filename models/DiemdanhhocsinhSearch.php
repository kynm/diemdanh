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
            [['MA_LOP', 'TEN_LOP', 'DIA_CHI', 'SO_DT', 'ID_DONVI'], 'safe'],
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
}
