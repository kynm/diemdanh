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
            [['ID_DONVI', 'STATUS', 'ID_HOCSINH'], 'safe'],
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

        $query->joinWith('hocsinh');
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'quanlyhocphithutruoc.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
        ]);
        $query->andFilterWhere(['=', 'quanlyhocphithutruoc.ID_LOP', $this->ID_LOP])
            ->andFilterWhere(['like', 'SOTIEN', $this->SOTIEN])
            ->andFilterWhere(['like', 'hocsinh.HO_TEN', $this->ID_HOCSINH])
            ->andFilterWhere(['=', 'quanlyhocphithutruoc.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'SO_BH', $this->SO_BH]);
        $query->orderBy([
            'STATUS' => SORT_ASC,
            'created_at' => SORT_DESC,
            'ID_LOP' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function baocaohocphithutruoc($params)
    {

        $sql = "SELECT b.TEN_LOP
            ,SUM(CASE WHEN b.`STATUS` = 1 then 1 ELSE 0 END) SO_HS
            ,SUM(CASE WHEN a.`STATUS` = 2 OR a.`STATUS` = 1 then 1 ELSE 0 END) SOLUONG
            ,SUM(CASE WHEN a.`STATUS` = 2 then 1 ELSE 0 END) DA_DONG
            ,SUM(CASE WHEN a.`STATUS` = 1 then 1 ELSE 0 END) CHUA_DONG
            ,SUM(a.TONGTIEN) TONGTIEN
            ,SUM(CASE WHEN a.`STATUS` = 2 then a.TONGTIEN ELSE 0 END) TIEN_DA_DONG
            ,SUM(CASE WHEN a.`STATUS` = 1 then a.TONGTIEN ELSE 0 END) TIEN_CHUA_DONG
            FROM lophoc b left join quanlyhocphithutruoc a on a.ID_LOP = b.ID_LOP where DATE(a.created_at) BETWEEN :TU_NGAY AND :DEN_NGAY AND b.ID_DONVI = :ID_DONVI GROUP BY b.TEN_LOP ORDER BY b.TEN_LOP";
            $data = Yii::$app->db->createCommand($sql)->bindValues(
                [
                    ':TU_NGAY' => $params['TU_NGAY'],
                    ':DEN_NGAY' => $params['DEN_NGAY'],
                    ':ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                ])->queryAll();

        return $data;
    }


    public function searchhocphitheohocsinh($params, $idhocsinh)
    {
        $query = Quanlyhocphithutruoc::find();

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
            'ID_HOCSINH' => $idhocsinh,
        ]);

        $query->andFilterWhere(['like', 'TIEUDE', $this->TIEUDE]);
        $query->orderBy([
            'STATUS' => SORT_ASC,
            'created_at' => SORT_DESC,
            'ID_LOP' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
