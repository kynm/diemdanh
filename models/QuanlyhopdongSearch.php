<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quanlyhopdong;
use app\models\Tramvt;
use app\models\Daivt;
use yii\helpers\ArrayHelper;

/**
 * NhanvienSearch represents the model behind the search form about `app\models\Nhanvien`.
 */
class QuanlyhopdongSearch extends Quanlyhopdong
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['NAM', 'THANG'], 'integer'],
            // [['MA_DONVIKT', 'MA_DIENLUC'], 'safe'],
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
        $query = Quanlyhopdong::find();

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

        // $query->joinWith('nHANVIENDIEUHANH');

        // grid filtering conditions
        $query->andFilterWhere([
            // 'MA_DIENLUC' => $params['MA_DIENLUC'],
        ]);

        // $query->orderBy([
        //     'NAM' => SORT_DESC,
        //     'THANG' => SORT_DESC,
        // ]);

        return $dataProvider;
    }

}
