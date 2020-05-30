<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quanlydien;
use app\models\Tramvt;
use app\models\Daivt;
use yii\helpers\ArrayHelper;

/**
 * NhanvienSearch represents the model behind the search form about `app\models\Nhanvien`.
 */
class QuanlydienSearch extends Quanlydien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['ID_NHANVIEN'], 'integer'],
            // [['MA_NHANVIEN', 'TEN_NHANVIEN', 'CHUC_VU', 'DIEN_THOAI', 'GHI_CHU', 'USER_NAME', 'ID_DONVI', 'ID_DAI'], 'safe'],
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

    public function searchThongkedien($params)
    {
        $query = Quanlydien::find();

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
            'NAM' => $params['NAM'],
            'THANG' => $params['THANG'],
        ]);

        if ($params['ID_DONVI']) {
            $dsdai = ArrayHelper::map(Daivt::find()->where(['ID_DONVI' => $params['ID_DONVI']])->all(), 'ID_DAI', 'ID_DAI');
            $danhsachtram = ArrayHelper::map(Tramvt::find()->where(['in', 'ID_DAI', $dsdai])->all(), 'MA_DIENLUC', 'MA_DIENLUC');
            $query->andFilterWhere(['in', 'MA_DIENLUC', $danhsachtram]);
        }

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Quanlydien::find();

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
            'MA_DIENLUC' => $params['MA_DIENLUC'],
        ]);

        // $query->andFilterWhere(['like', 'MA_NHANVIEN', $this->MA_NHANVIEN])
        //     ->andFilterWhere(['like', 'TEN_NHANVIEN', $this->TEN_NHANVIEN])
        //     ->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI])
        //     ->andFilterWhere(['like', 'daivt.TEN_DAIVT', $this->ID_DAI])
        //     ->andFilterWhere(['like', 'CHUC_VU', $this->CHUC_VU])
        //     ->andFilterWhere(['like', 'DIEN_THOAI', $this->DIEN_THOAI])
        //     ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
        //     ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME]);

        return $dataProvider;
    }

    public function baocaodsdientheodonvi($params)
    {
        $sql = "
            SELECT a.MA_DIENLUC, a.MA_CSHT, a.TIENDIEN,a.TIENTHUE, a.TONGTIEN,a.TEN_DIENLUC,a.TK_DIENLUC,a.NH_DIENLUC, a.MA_DONVIKT 
            from quanlydien a where a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ")";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function baocaothdientheodonvi($params)
    {
        $sqltonghop = "
            SELECT b.TEN_DONVI, COUNT(a.MA_DIENLUC) SO_TRAM, SUM(a.TIENDIEN) TIENDIEN, SUM(a.TIENTHUE) TIENTHUE, SUM(a.TONGTIEN) TONGTIEN 
            FROM quanlydien a, donvi b 
            where a.MA_DONVIKT = b.MA_DONVIKT and a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") GROUP by b.TEN_DONVI";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function baocaothdientheonganhang($params)
    {
        $sqltonghop = "
            SELECT a.TEN_DIENLUC,a.TK_DIENLUC, sum(a.TIENDIEN) T_TIENDIEN,sum(a.TIENTHUE) T_TIENTHUE, sum(a.TONGTIEN) T_TONGTIEN,a.TEN_DIENLUC TEN_DIENLUC1,a.TK_DIENLUC TK_DIENLUC1,a.NH_DIENLUC NH_DIENLUC 
            from quanlydien a where a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") GROUP BY a.TK_DIENLUC,a.NH_DIENLUC,a.TEN_DIENLUC";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }
}
