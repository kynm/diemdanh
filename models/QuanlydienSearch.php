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
            [['NAM', 'THANG'], 'integer'],
            [['MA_DONVIKT', 'MA_DIENLUC'], 'safe'],
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

        // if ($params['ID_DONVI']) {
        //     $query->andFilterWhere(['in', 'MA_DONVIKT', $params['ID_DONVI']]);
        // }

        // if ($params['NAM']) {
        //     $query->andFilterWhere(['NAM' => $params['NAM']]);
        // }

        // if ($params['THANG']) {
        //     $query->andFilterWhere(['THANG' => $params['THANG']]);
        // }
        $query->joinWith('donvitheomaketoan');
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $query->andFilterWhere(['quanlydien.MA_DONVIKT' => Donvi::findone(Yii::$app->user->identity->nhanvien->ID_DONVI)->MA_DONVIKT]);
        }
        $query->andFilterWhere(['quanlydien.MA_DONVIKT' => $this->MA_DONVIKT]);
        $query->andFilterWhere(['like', 'NAM', $this->NAM])
            ->andFilterWhere(['like', 'MA_DIENLUC', $this->MA_DIENLUC])
            ->andFilterWhere(['like', 'THANG', $this->THANG]);

        $query->orderBy([
            'NAM' => SORT_DESC,
            'THANG' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function searchThongkedienvuotdinhmuc($params)
    {
        $query = Quanlydien::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('donvitheomaketoan');
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $query->andFilterWhere(['quanlydien.MA_DONVIKT' => Donvi::findone(Yii::$app->user->identity->nhanvien->ID_DONVI)->MA_DONVIKT]);
        }
        $query->andWhere('KW_TIEUTHU >= DINHMUC');
        $query->andFilterWhere(['quanlydien.MA_DONVIKT' => $this->MA_DONVIKT]);
        $query->andFilterWhere(['like', 'NAM', $this->NAM])
            ->andFilterWhere(['like', 'MA_DIENLUC', $this->MA_DIENLUC])
            ->andFilterWhere(['like', 'THANG', $this->THANG]);

        $query->orderBy([
            'NAM' => SORT_DESC,
            'THANG' => SORT_DESC,
        ]);
        return $dataProvider;
    }

    public function searchThongkedienchuathanhtoan($params)
    {
        $query = Quanlydien::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'pagination' => [
            //     'pageSize' => 4,
            // ],
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['is', 'IS_CHECKED', new \yii\db\Expression('null')]);
        $query->joinWith('donvitheomaketoan');
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $query->andFilterWhere(['quanlydien.MA_DONVIKT' => Donvi::findone(Yii::$app->user->identity->nhanvien->ID_DONVI)->MA_DONVIKT]);
        }
        $query->andFilterWhere(['quanlydien.MA_DONVIKT' => $this->MA_DONVIKT]);
        $query->andFilterWhere(['like', 'NAM', $this->NAM])
            ->andFilterWhere(['like', 'MA_DIENLUC', $this->MA_DIENLUC])
            ->andFilterWhere(['like', 'THANG', $this->THANG]);

        $query->orderBy([
            'NAM' => SORT_DESC,
            'THANG' => SORT_DESC,
        ]);
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

        $query->orderBy([
            'NAM' => SORT_DESC,
            'THANG' => SORT_DESC,
        ]);

        return $dataProvider;
    }

    public function baocaodsdientheodonvi($params)
    {
        if ($params['IS_CHECKED']) {
            $sql = "
            SELECT a.MA_DIENLUC, a.MA_CSHT, a.TIENDIEN,a.TIENTHUE, a.TONGTIEN,a.TEN_DIENLUC,a.TK_DIENLUC,a.NH_DIENLUC, a.MA_DONVIKT 
            from quanlydien a where a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ")";
        } else {
            $sql = "
            SELECT a.MA_DIENLUC, a.MA_CSHT, a.TIENDIEN,a.TIENTHUE, a.TONGTIEN,a.TEN_DIENLUC,a.TK_DIENLUC,a.NH_DIENLUC, a.MA_DONVIKT 
            from quanlydien a where  a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") AND a.IS_CHECKED IS NULL";
        }

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function baocaothdientheodonvi($params)
    {
        if ($params['IS_CHECKED']) {
            $sqltonghop = "
            SELECT b.TEN_DONVI, COUNT(a.MA_DIENLUC) SO_TRAM, SUM(a.TIENDIEN) TIENDIEN, SUM(a.TIENTHUE) TIENTHUE, SUM(a.TONGTIEN) TONGTIEN 
            FROM quanlydien a, donvi b 
            where a.MA_DONVIKT = b.MA_DONVIKT and a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ")  GROUP by b.TEN_DONVI";
        } else {
            $sqltonghop = "
            SELECT b.TEN_DONVI, COUNT(a.MA_DIENLUC) SO_TRAM, SUM(a.TIENDIEN) TIENDIEN, SUM(a.TIENTHUE) TIENTHUE, SUM(a.TONGTIEN) TONGTIEN 
            FROM quanlydien a, donvi b 
            where a.MA_DONVIKT = b.MA_DONVIKT and a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") AND a.IS_CHECKED IS NULL GROUP by b.TEN_DONVI";
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function baocaothdientheonganhang($params)
    {
        if ($params['IS_CHECKED']) {
            $sqltonghop = "
            SELECT a.TEN_DIENLUC,a.TK_DIENLUC, sum(a.TIENDIEN) T_TIENDIEN,sum(a.TIENTHUE) T_TIENTHUE, sum(a.TONGTIEN) T_TONGTIEN,a.TEN_DIENLUC TEN_DIENLUC1,a.TK_DIENLUC TK_DIENLUC1,a.NH_DIENLUC NH_DIENLUC 
            from quanlydien a where a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") GROUP BY a.TK_DIENLUC,a.NH_DIENLUC,a.TEN_DIENLUC";
        } else {
            $sqltonghop = "
            SELECT a.TEN_DIENLUC,a.TK_DIENLUC, sum(a.TIENDIEN) T_TIENDIEN,sum(a.TIENTHUE) T_TIENTHUE, sum(a.TONGTIEN) T_TONGTIEN,a.TEN_DIENLUC TEN_DIENLUC1,a.TK_DIENLUC TK_DIENLUC1,a.NH_DIENLUC NH_DIENLUC 
            from quanlydien a where a.THANG = " . $params['THANG'] . " and a.NAM = " . $params['NAM'] . " and a.MA_DONVIKT 
            in (" . $params['dsdonvi'] . ") AND a.IS_CHECKED IS NULL GROUP BY a.TK_DIENLUC,a.NH_DIENLUC,a.TEN_DIENLUC";
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tonghoptheodonvi($madv, $nam)
    {
        $sqltonghop = "SELECT THANG, sum(KW_TIEUTHU) KW_TIEUTHU FROM `quanlydien` where MA_DONVIKT = " . $madv . " AND NAM = " . $nam . " GROUP by THANG";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tonghoptheotram($madv, $nam, $loai ='KW_TIEUTHU')
    {
        $sqltonghop = "SELECT THANG, sum(" . $loai . ") TONG_TT FROM `quanlydien` where MA_DIENLUC = '" . $madv . "' AND NAM = " . $nam . " GROUP by THANG";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tonghoptramphatsinhtheodonvi($madv, $nam)
    {
        $sqltonghop = "SELECT THANG, count(MA_DIENLUC) TONGTRAM FROM `quanlydien` where MA_DONVIKT = " . $madv . " AND NAM = " . $nam . " GROUP by THANG";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tonghoptramphatsinhtheotram()
    {
        $sqltonghop = "SELECT a.MA_CSHT, (SELECT ten_tram from tramvt where MA_CSHT = a.MA_CSHT LIMIT 1) TEN_TRAM, A.THANG, A.KW_TIEUTHU, A.TONGTIEN from quanlydien a order By a.THANG";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }

    public function tramchuamap($params)
    {
        $sqltonghop = "select a.id, (select ten_donvi from donvi where MA_DONVIKT = a.MA_DONVIKT) tendv,a.THANG, a.ma_dienluc, a.ma_csht from quanlydien a where a.THANG in (" . $params['THANG'] . ") and ( a.ma_csht not in (SELECT ma_csht from tramvt) OR a.MA_CSHT is null) ORDER BY a.MA_DONVIKT";

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }
}
