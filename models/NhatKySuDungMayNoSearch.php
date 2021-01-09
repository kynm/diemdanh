<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NhatKySuDungMayNo;
use yii\helpers\ArrayHelper;
use app\models\Tramvt;
use app\models\Daivt;

class NhatKySuDungMayNoSearch extends NhatKySuDungMayNo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['THOIGIANBATDAU', 'date', 'timestampAttribute' => 'THOIGIANBATDAU', 'format' => 'php:d-m-y'],
            // ['THOIGIANKETTHUC', 'date', 'timestampAttribute' => 'THOIGIANKETTHUC', 'format' => 'php:d-m-y'],
            [['ID_TRAM'], 'safe'],
            [['ID_DAI'], 'safe'],
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
            SELECT b.TEN_TRAM,e.TEN_THIETBI, a.DINHMUC,CASE WHEN (a.LOAINHIENLIEU = 1) THEN 'Diesel' WHEN (a.LOAINHIENLIEU = 2) THEN 'Xăng' END AS LOAINHIENLIEU,a.GIATIEN, a.THOIGIANBATDAU, a.THOIGIANKETTHUC, TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC) THOI_GIAN, (TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC)/60 * a.DINHMUC) TONGSOLUONG  FROM nhatkysudungmayno a, tramvt b, thietbitram c, daivt d,thietbi e WHERE a.ID_TRAM = b.ID_TRAM and b.ID_DAI = d.ID_DAI and c.ID_LOAITB = e.id_thietbi and a.ID_THIETBITRAM = c.ID_THIETBI and d.ID_DONVI = " . $params['ID_DONVI'] . " AND MONTH(a.THOIGIANBATDAU) = '" . $params['THANG'] . "' AND year(a.THOIGIANBATDAU) = '" . $params['NAM'] . "' ORDER BY a.THOIGIANBATDAU, a.THOIGIANKETTHUC";

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
            " and month(a.THOIGIANBATDAU) = " . $params['THANG'] . " GROUP BY DAYOFMONTH(a.THOIGIANBATDAU)
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function searchbaocaodaitram($params)
    {
        $query = NhatKySuDungMayNo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith('tRAMVANHANH');
        $query->joinWith('tHIETBITRAM');
        if (Yii::$app->user->can('truongdai-mayno')) {
            // $iddais = ArrayHelper::map(Daivt::find()->where(['=', 'ID_DONVI', Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_DAI', 'ID_DAI');
            $idTram = ArrayHelper::map(Tramvt::find()->where(['=', 'ID_DAI', Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_TRAM', 'ID_TRAM');
            $query->andFilterWhere(['in', 'nhatkysudungmayno.ID_TRAM', $idTram]);
        }
        $query->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM]);
        // ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_DAI])
        // ->andFilterWhere(['between', 'THOIGIANBATDAU', $this->THOIGIANBATDAU, $this->THOIGIANKETTHUC]);

        $query->orderBy([
            'THOIGIANBATDAU' => SORT_DESC,
        ]);

        return $dataProvider;
    }

    public function tonghoptheotram($idtram, $nam, $loai ='THOIGIAN')
    {
        if ($loai == 'THOIGIAN') {
            # code...
        }
        switch ($loai) {
            case 'THOIGIAN':
                $sqltonghop = "SELECT b.TEN_TRAM,MONTH(a.THOIGIANBATDAU) THANG, ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60,2) TONG from nhatkysudungmayno a, tramvt b where a.ID_TRAM = b.ID_TRAM AND a.ID_TRAM = '" . $idtram . "' AND year(a.THOIGIANBATDAU) = '" . $nam . "'  GROUP by MONTH(a.THOIGIANBATDAU),b.TEN_TRAM";
                break;
            case 'SOLUONG':
                $sqltonghop = "SELECT b.TEN_TRAM,MONTH(a.THOIGIANBATDAU) THANG, ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60,2) * a.DINHMUC TONG from nhatkysudungmayno a, tramvt b where a.ID_TRAM = b.ID_TRAM AND a.ID_TRAM = '" . $idtram . "' AND year(a.THOIGIANBATDAU) = '" . $nam . "'  GROUP by MONTH(a.THOIGIANBATDAU),b.TEN_TRAM";
                break;
            case 'TONGTIEN':
                $sqltonghop = "SELECT b.TEN_TRAM,MONTH(a.THOIGIANBATDAU) THANG, ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60,2) * a.DINHMUC * a.GIATIEN TONG from nhatkysudungmayno a, tramvt b where a.ID_TRAM = b.ID_TRAM AND a.ID_TRAM = '" . $idtram . "' AND year(a.THOIGIANBATDAU) = '" . $nam . "'  GROUP by MONTH(a.THOIGIANBATDAU),b.TEN_TRAM";
                break;
            
            default:
                $sqltonghop = "SELECT b.TEN_TRAM,MONTH(a.THOIGIANBATDAU) THANG, ROUND(sum(TIMESTAMPDIFF(MINUTE, a.THOIGIANBATDAU, a.THOIGIANKETTHUC))/60,2) TONG from nhatkysudungmayno a, tramvt b where a.ID_TRAM = b.ID_TRAM AND a.ID_TRAM = '" . $idtram . "' AND year(a.THOIGIANBATDAU) = '" . $nam . "'  GROUP by MONTH(a.THOIGIANBATDAU),b.TEN_TRAM";
                break;
        }

        return Yii::$app->db->createCommand($sqltonghop)->queryAll();
    }
}
