<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quanlyhocphi;

/**
 * QuanlyhocphiSearch represents the model behind the search form about `app\models\Quanlyhocphi`.
 */
class QuanlyhocphiSearch extends Quanlyhocphi
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


    public function searchhocphitheodonvi($params)
    {
        $query = Quanlyhocphi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP]);
        $query->orderBy([
            'TU_NGAY' => SORT_DESC,
            'DEN_NGAY' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
