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
            [['ma_tb', 'status'], 'integer'],
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
    public function search($params, $type)
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
        if (Yii::$app->user->can('dmdv-xlbaohong') || Yii::$app->user->can('dmdv-kinhdoanh')) {
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
        if (Yii::$app->user->can('Administrator') || Yii::$app->user->can('dmdv-xlbaohong')  || Yii::$app->user->can('dmdv-kinhdoanh')) {
            $query->andFilterWhere(['in', 'donvi_id', $iddv]);
        }

        if (Yii::$app->user->can('nhanvien-kd-baohong') && !Yii::$app->user->can('dmdv-kinhdoanh')) {
            $query->andFilterWhere(['nhanvien_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }

        if (Yii::$app->user->can('xuly-baohong')) {
           $query->andFilterWhere(['nhanvien_xl_id' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }

        $query->andFilterWhere(['like', 'baohong.ten_kh', $this->ten_kh]);
        $query->andFilterWhere(['like', 'baohong.so_dt', $this->so_dt]);
        $query->andFilterWhere(['like', 'baohong.diachi', $this->diachi]);
        $query->andFilterWhere(['like', 'baohong.ma_tb', $this->ma_tb]);
        $query->andFilterWhere(['=', 'baohong.status', $this->status]);

        //type = 0: tìm kiếm lịch sử, $type = 1: module điều hành
        switch ($type) {
            case 0:
                $query->andFilterWhere(['in', 'baohong.status', [4,5]]);
                break;
            case 1:
                $query->andFilterWhere(['not in', 'baohong.status', [4,5]]);
                break;
            default:
                $query->andFilterWhere(['not in', 'baohong.status', [4,5]]);
                break;
        }

        $query->orderBy([
            'ngay_xl' => SORT_ASC,
            'status'=>SORT_DESC,
            'ngay_bh'=>SORT_ASC,
        ]);
        return $dataProvider;
    }

    public function baocaotheonhanvienxuly($params)
    {
        $result = $this->getStartDateEndDate($params);
        $startDate = $result['startDate'];
        $endDate = $result['endDate'];
        $iddv = Yii::$app->user->identity->nhanvien->ID_DONVI;
        if (Yii::$app->user->can('quanlybaocao')) {
            $iddv = '2,3,4,5,6,7';
        }
        return Yii::$app->db->createCommand('SELECT b.ten_nhanvien TEN_NHANVIEN, SUM(CASE WHEN a.STATUS = 0 THEN 1 ELSE 0 END) AS CHUA_XL ,SUM(CASE WHEN a.STATUS = 3 OR a.status = 1 THEN 1 ELSE 0 END) AS CHUA_OUTBOUND ,SUM(CASE WHEN a.STATUS = 4 or a.status = 5 THEN 1 ELSE 0 END) AS HOANTHANH FROM baohong a,nhanvien b where a.nhanvien_xl_id = b.id_nhanvien AND a.donvi_id in(' . $iddv . ') and date(a.ngay_bh) BETWEEN "' . $startDate . '" and "' . $endDate . '" GROUP by b.ten_nhanvien')->queryAll();
    }

    public function baocaotheonhanvienbaohong($params)
    {
        $result = $this->getStartDateEndDate($params);
        $startDate = $result['startDate'];
        $endDate = $result['endDate'];
        $iddv = Yii::$app->user->identity->nhanvien->ID_DONVI;
        if (Yii::$app->user->can('quanlybaocao')) {
            $iddv = '2,3,4,5,6,7';
        }
        return Yii::$app->db->createCommand('SELECT b.ten_nhanvien TEN_NHANVIEN, SUM(CASE WHEN a.STATUS = 0 THEN 1 ELSE 0 END) AS CHUA_XL ,SUM(CASE WHEN a.STATUS = 3 OR a.status = 1 THEN 1 ELSE 0 END) AS CHUA_OUTBOUND ,SUM(CASE WHEN a.STATUS = 4 or a.status = 5 THEN 1 ELSE 0 END) AS HOANTHANH FROM baohong a,nhanvien b where a.nhanvien_id = b.id_nhanvien  AND a.donvi_id in(' . $iddv . ') and date(a.ngay_bh) BETWEEN "' . $startDate . '" and "' . $endDate . '" GROUP by b.ten_nhanvien')->queryAll();
    }

    public function baocaobaohongnhieulan($params)
    {
        $result = $this->getStartDateEndDate($params);
        $startDate = $result['startDate'];
        $endDate = $result['endDate'];
        $iddv = Yii::$app->user->identity->nhanvien->ID_DONVI;
        if (Yii::$app->user->can('quanlybaocao')) {
            $iddv = '2,3,4,5,6,7';
        }
        return Yii::$app->db->createCommand('SELECT b.TEN_DONVI,a.ma_tb MA_TB, COUNT(*) SO_LUONG FROM baohong a, donvi b where a.donvi_id = b.ID_DONVI AND a.donvi_id in(' . $iddv . ') and date(a.ngay_bh) BETWEEN "' . $startDate . '" and "' . $endDate . '"  GROUP BY b.TEN_DONVI,a.ma_tb  HAVING COUNT(*) > 1 ORDER BY b.TEN_DONVI')->queryAll();
    }


    public function getStartDateEndDate($params)
    {
        $type = isset($params['type']) ? $params['type'] : 6;
        switch ($type) {
            case 1:
                $text = 'Hôm qua'; //ok
                $startDate = date('Y-m-01', strtotime('-1 days'));
                $endDate = date('Y-m-01', strtotime('-1 days'));
                break;
            case 2:
                $text = 'Tuần trước';
                $startDate = date('Y-m-d', strtotime('-1 weeks'));
                die(var_dump($startDate));
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
            case 3:
                $text = 'Tháng trước'; //ok
                $startDate = date('Y-m-01',strtotime('-1 months'));
                $endDate = date('Y-m-t',strtotime('-1 months'));
                break;
            case 4:
                $text = 'Quý trước';
                $text = 'Hôm nay';
                $startDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
            case 5:
                $text = 'Tuần hiện tại'; //ok
                $startDate = date("Y-m-d", strtotime('monday this week'));
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
            case 6:
                $text = 'Tháng hiện tại'; //ok
                $startDate = date('Y-m-01');
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
            case 7:
                $text = 'Quý hiện tại';
                $text = 'Hôm nay';
                $startDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
            case 8:
                $text = 'Năm hiện tại'; //ok
                $startDate = date( 'Y' ) . '-01-01';
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;

            default:
                $text = 'Hôm nay'; //ok
                $startDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                $endDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
                break;
        }

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'text' => $text,
        ];
    }
}
