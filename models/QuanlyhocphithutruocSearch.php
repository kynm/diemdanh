<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quanlyhocphithutruoc;

/**
 * LophocSearch represents the model behind the search form about `app\models\Lophoc`.
 */
class QuanlyhocphithutruocSearch extends Quanlyhocphithutruoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_LOP'], 'integer'],
            [['ID_DONVI'], 'safe'],
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
    public function searchhocphithutruoctheodonvi($params)
    {
        $query = Quanlyhocphithutruoc::find();

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
        $query->andFilterWhere([
            'quanlyhocphithutruoc.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);

        $query->andFilterWhere(['=', 'ID_LOP', $this->ID_LOP])
            ->andFilterWhere(['like', 'SOTIEN', $this->SOTIEN])
            ->andFilterWhere(['like', 'SO_BH', $this->SO_BH]);

        return $dataProvider;
    }
}
