<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donhang;
class DonhangSearch extends Donhang
{
    /**
     * @inheritdoc
     */

    public $SO_DT;


    public function rules()
    {
        return [
            [['ID_DONVI', 'STATUS', 'TYPE', 'SO_DT'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = Donhang::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('donvi');

        $query->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI]);
        $query->andFilterWhere(['like', 'donvi.SO_DT', $this->SO_DT]);
        $query->andFilterWhere(['=', 'donhang.STATUS', $this->STATUS]);
        $query->andFilterWhere(['=', 'TYPE', $this->TYPE]);
        $query->orderBy([
            'created_at' => SORT_DESC,
            'STATUS' => SORT_ASC,
        ]);

        return $dataProvider;
    }
}
