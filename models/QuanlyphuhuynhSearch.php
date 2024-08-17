<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nhanvien;

/**
 * QuanlyphuhuynhSearch represents the model behind the search form about `app\models\Nhanvien`.
 */
class QuanlyphuhuynhSearch extends Nhanvien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_NHANVIEN'], 'integer'],
            [['TEN_NHANVIEN',  'DIEN_THOAI', 'GHI_CHU', 'USER_NAME', 'ID_DONVI'], 'safe'],
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
        $query = Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0]);

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

        $query->joinWith('iDDONVI');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
            'CHUC_VU' => 5,
        ]);

        $query->andFilterWhere(['like', 'TEN_NHANVIEN', $this->TEN_NHANVIEN])
            ->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI])
            ->andFilterWhere(['like', 'DIEN_THOAI', $this->DIEN_THOAI])
            ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
            ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME]);

        return $dataProvider;
    }

    public function dsnhanviendonvi($params)
    {
        $query = Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0]);

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

        $query->joinWith('iDDONVI');

        // grid filtering conditions
        $query->andFilterWhere([
            'donvi.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
            'CHUC_VU' => 5,
        ]);

        $query->andFilterWhere(['like', 'TEN_NHANVIEN', $this->TEN_NHANVIEN])
            ->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI])
            ->andFilterWhere(['like', 'DIEN_THOAI', $this->DIEN_THOAI])
            ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
            ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME]);

        return $dataProvider;
    }
}
