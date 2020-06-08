<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NhatKySuDungMayNo;
use yii\helpers\ArrayHelper;

class NhatKySuDungMayNoSearch extends NhatKySuDungMayNo
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
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function searchKetoan($params)
    {
        $query = NhatKySuDungMayNo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('tHIETBITRAM');
        $query->andFilterWhere(['in', 'tHIETBITRAM.ID_TRAM', [141,20,205]])
            // ->andFilterWhere(['like', 'GHI_CHU', $this->GHI_CHU])
            ->andFilterWhere(['>=' , 'THOIGIANBATDAU', $params['THANG']]);

        return $dataProvider;
    }
    public function search($params)
    {
        $query = NhatKySuDungMayNo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('nHANVIENVANHANH');
        $query->andFilterWhere([
            'ID_THIETBITRAM' => $params['ID_THIETBITRAM'],
        ]);
        $query->orderBy([
            'THOIGIANBATDAU' => SORT_DESC,
        ]);

        return $dataProvider;
    }

    public function baocaomaynotheothang($params)
    {
        $sql = "
            SELECT b.TEN_TRAM,e.TEN_THIETBI, a.DINHMUC,CASE WHEN (a.LOAINHIENLIEU = 1) THEN 'Diesel' WHEN (a.LOAINHIENLIEU = 2) THEN 'Xăng' END AS LOAINHIENLIEU,a.GIATIEN, sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC)) THOI_GIAN FROM nhatkysudungmayno a, tramvt b, thietbitram c, daivt d,thietbi e WHERE a.ID_TRAM = b.ID_TRAM and b.ID_DAI = d.ID_DAI and c.ID_LOAITB = e.id_thietbi and a.ID_THIETBITRAM = c.ID_THIETBI and d.ID_DONVI = " . $params['ID_DONVI'] . " AND MONTH(a.THOIGIANBATDAU) = '" . $params['THANG'] . "' AND year(a.THOIGIANBATDAU) = '" . $params['NAM'] . "' GROUP by b.TEN_TRAM,a.ID_THIETBITRAM,a.LOAINHIENLIEU, a.DINHMUC, e.TEN_THIETBI
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function baocaomaynotheothangchitiet($params)
    {
        $sql = "
            SELECT b.TEN_TRAM,e.TEN_THIETBI, a.DINHMUC,CASE WHEN (a.LOAINHIENLIEU = 1) THEN 'Diesel' WHEN (a.LOAINHIENLIEU = 2) THEN 'Xăng' END AS LOAINHIENLIEU,a.GIATIEN, a.THOIGIANBATDAU, a.THOIGIANKETTHUC, TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC) THOI_GIAN FROM nhatkysudungmayno a, tramvt b, thietbitram c, daivt d,thietbi e WHERE a.ID_TRAM = b.ID_TRAM and b.ID_DAI = d.ID_DAI and c.ID_LOAITB = e.id_thietbi and a.ID_THIETBITRAM = c.ID_THIETBI and d.ID_DONVI = " . $params['ID_DONVI'] . " AND MONTH(a.THOIGIANBATDAU) = '" . $params['THANG'] . "' AND year(a.THOIGIANBATDAU) = '" . $params['NAM'] . "' ORDER BY a.THOIGIANBATDAU, a.THOIGIANKETTHUC";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function getDongiatheothang($params)
    {
        return ArrayHelper::map(Dongiamayno::find()
                ->where(['THANG' => $params['THANG'], 'NAM' => $params['NAM']])->all(), 'LOAI_NHIENLIEU', 'DONGIA');
    }

    public function getloainhienlieu()
    {
        return [
            1 => 'Diesel',
            2 => 'Xăng',
        ];
    }

    public function baocaotonghoptheothang($params)
    {
        $sql = "
            SELECT MONTH(THOIGIANBATDAU) THANG,ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60, 2) TONG_THOI_GIAN FROM nhatkysudungmayno a, tramvt b, thietbitram c, daivt d,thietbi e 
            WHERE a.ID_TRAM = b.ID_TRAM and b.ID_DAI = d.ID_DAI and c.ID_LOAITB = e.id_thietbi and a.ID_THIETBITRAM = c.ID_THIETBI  
            AND year(a.THOIGIANBATDAU) = '" . $params['NAM'] . "' and d.ID_DONVI = " . $params['ID_DONVI'] . 
            " GROUP by MONTH(THOIGIANBATDAU)
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function baocaotonghoptrongthang($params)
    {
        $sql = "
            SELECT DAYOFMONTH(a.THOIGIANBATDAU) NGAY,ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60,2) TONG_THOI_GIAN FROM nhatkysudungmayno a, tramvt b, thietbitram c, daivt d,thietbi e 
             WHERE a.ID_TRAM = b.ID_TRAM and b.ID_DAI = d.ID_DAI and c.ID_LOAITB = e.id_thietbi and a.ID_THIETBITRAM = c.ID_THIETBI  
             AND year(a.THOIGIANBATDAU) = '" . $params['NAM'] . "' and d.ID_DONVI = " . $params['ID_DONVI'] .  
            " and month(a.THOIGIANBATDAU) = " . date('m') . " GROUP BY DAYOFMONTH(a.THOIGIANBATDAU)
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}
