<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chitiethocphi;
/**
 * ChitiethocphiSearch represents the model behind the search form about `app\models\Chitiethocphi`.
 */
class ChitiethocphiSearch extends Chitiethocphi
{
    /**
     * @inheritdoc
     */

    public $TIEUDE;
    public $ID_LOP;

    public function rules()
    {
        return [
            [['ID_QUANLYHOCPHI', 'TIEUDE', 'STATUS', 'ID_LOP', 'ID_HOCSINH'], 'safe'],
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


    public function searchchitiethocphitheodonvi($params)
    {
        $query = Chitiethocphi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('hocphi');
        $query->joinWith('hocsinh');

        // grid filtering conditions
        $query->andFilterWhere([
            'quanlyhocphi.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'quanlyhocphi.TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['=', 'quanlyhocphi.ID_LOP', $this->ID_LOP]);
        $query->andFilterWhere(['like', 'hocsinh.HO_TEN', $this->ID_HOCSINH]);
        $query->andFilterWhere(['=', 'chitiethocphi.STATUS', isset($this->STATUS) ? $this->STATUS : 0]);
        $query->orderBy([
            'chitiethocphi.STATUS' => SORT_ASC,
            'quanlyhocphi.ID_LOP' => SORT_DESC,
            'quanlyhocphi.created_at' => SORT_DESC,
        ]);

        return $dataProvider;
    }

    public function searchhocphitheohocsinh($params, $idhocsinh)
    {
        $query = Chitiethocphi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('hocphi');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_HOCSINH' => $idhocsinh,
        ]);

        $query->andFilterWhere(['like', 'quanlyhocphi.TIEUDE', $this->TIEUDE]);
        $query->orderBy([
            'STATUS' => SORT_ASC,
            'quanlyhocphi.created_at' => SORT_DESC,
            'quanlyhocphi.ID_LOP' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
