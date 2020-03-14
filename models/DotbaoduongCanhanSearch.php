<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dotbaoduong;
use app\models\Kehoachbdtb;

/**
 * DotbaoduongSearch represents the model behind the search form about `app\models\Dotbaoduong`.
 */
class DotbaoduongCanhanSearch extends Dotbaoduong
{
     // Virtual variable
    public $ID_DAI;
    public $ID_DONVI;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_DAI', 'ID_DONVI'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['MA_DOTBD', 'NGAY_BD', 'ID_TRAM', 'ID_NHANVIEN', 'NGAY_DUKIEN', 'NGAY_KT', 'NGAY_KT_DUKIEN', 'ID_BDT'], 'safe'],
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


    public function searchDskh($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'kehoach'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
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
            'NGAY_BD' => $this->NGAY_BD,
            'dotbaoduong.TRANGTHAI' => $this->TRANGTHAI,
            'baoduongtong.MA_BDT' => $this->ID_BDT,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            // ->andFilterWhere(['like', 'baoduongtong.MA_BDT', $this->ID_BDT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        return $dataProvider;
    }

    public function searchDsth($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'dangthuchien' ])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['<>', 'baoduongtong.TYPE', 2]);
        $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'dotbaoduong.TRANGTHAI' => $this->TRANGTHAI,
            'baoduongtong.MA_BDT' => $this->ID_BDT,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        return $dataProvider;
    }


    public function searchChxn($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'chuahoanthanh'])->orderBy(['NGAY_BD' => SORT_ASC]);
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('tRAMVT');
        $query->joinWith('nHANVIEN');
        // $query->joinWith('baocao');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'dotbaoduong.TRANGTHAI' => $this->TRANGTHAI,
            'baoduongtong.MA_BDT' => $this->ID_BDT,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            // ->andFilterWhere(['like', 'baoduongtong.MA_BDT', $this->ID_BDT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        return $dataProvider;
    }


    public function searchKtbd($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'ketthuc'])->orderBy(['NGAY_BD' => SORT_ASC]);
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'dotbaoduong.TRANGTHAI' => $this->TRANGTHAI,
            'baoduongtong.MA_BDT' => $this->ID_BDT,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        return $dataProvider;
    }

}
