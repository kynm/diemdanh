<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Thuchienbd;

/**
 * ThuchienbdSearch represents the model behind the search form about `app\models\Thuchienbd`.
 */
class ThuchienbdSearch extends Thuchienbd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN'], 'integer'],
            [['MA_NOIDUNG', 'NOIDUNGMORONG', 'GHICHU', 'KETQUA'], 'safe'],
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
        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Đang thực hiện']);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'ID_THIETBI' => $this->ID_THIETBI,
            'KETQUA' => $this->KETQUA,
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
        ]);

        $query->andFilterWhere(['like', 'MA_NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'NOIDUNGMORONG', $this->NOIDUNGMORONG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU]);

        return $dataProvider;
    }

    public function searchND($params)
    {
        $query = Thuchienbd::find()->where(['ID_DOTBD' => $params['id']]);

        // add conditions that should always apply here
        // print_r($params);
        // die;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
