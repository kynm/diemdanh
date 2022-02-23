<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Baohong;

/**
 * BaohongSearch represents the model behind the search form about `app\models\Baohong`.
 */
class BaohongSearch extends Baohong
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhanvien_id', 'nhanvien_xl_id'], 'integer'],
            [['ten_kh', 'diachi', 'so_dt'], 'safe'],
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
        $query = Baohong::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $iddv = [];
        if (Yii::$app->user->can('Administrator')) {
            $iddv = [2,3,4,5,6,7];
        }
        if (Yii::$app->user->can('dmdv-xlbaohong')) {
            $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('iDDONVI');
        // $query->joinWith('iDDAI');
        // // grid filtering conditions
        if (Yii::$app->user->can('Administrator') || Yii::$app->user->can('dmdv-xlbaohong')) {
            $query->andFilterWhere(['in', 'donvi_id', $iddv]);
        }

        if (Yii::$app->user->can('nhanvien-kd-baohong')) {
            $query->andFilterWhere(['nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }

        if (Yii::$app->user->can('xuly-baohong')) {
            $query->andFilterWhere(['nhanvien_xl_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }

        $query->andFilterWhere(['like', 'baohong.ten_kh', $this->ten_kh]);
        $query->andFilterWhere(['like', 'baohong.so_dt', $this->so_dt]);
        $query->andFilterWhere(['like', 'baohong.diachi', $this->diachi]);

        $query->orderBy([
            'ngay_xl' => SORT_ASC,
            'id'=>SORT_ASC,
        ]);
        return $dataProvider;
    }
}
