<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hocphitheokhoa;

/**
 * HocphitheokhoaSearch represents the model behind the search form about `app\models\Hocphitheokhoa`.
 */
class HocphitheokhoaSearch extends Hocphitheokhoa
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
        $query = Hocphitheokhoa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('lop');
        // grid filtering conditions
        $query->andFilterWhere([
            'hocphitheokhoa.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'TIEUDE', $this->TIEUDE]);
        $query->andFilterWhere(['=', 'hocphitheokhoa.ID_LOP', $this->ID_LOP]);
        $query->orderBy([
            'created_at' => SORT_DESC,
            'lophoc.TEN_LOP' => SORT_DESC,
            'TU_NGAY' => SORT_DESC,
            'DEN_NGAY' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
