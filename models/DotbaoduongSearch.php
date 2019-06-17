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
class DotbaoduongSearch extends Dotbaoduong
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->orderBy(['NGAY_BD' => SORT_ASC]);

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

        $query->joinWith('tRAMVT');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['<>', 'baoduongtong.TYPE', 2]);

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchBaocaoktnt($id, $params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.ID_BDT' => $id]);

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

        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        // $query->andWhere(['baoduongtong.TYPE' => 2]);

        // grid filtering conditions
        $query->andFilterWhere([
            'dotbaoduong.ID_DOTBD' => $this->ID_DOTBD,
            'dotbaoduong.NGAY_BD' => $this->NGAY_BD,
            'dotbaoduong.TRANGTHAI' => $this->TRANGTHAI,
            'daivt.ID_DAI' => $this->ID_DAI,
            'daivt.ID_DONVI' => $this->ID_DONVI,
        ]);

        $query->andFilterWhere(['like', 'dotbaoduong.MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN]);

        
        return $dataProvider;
    }

    public function searchGiaonhiemvu($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'kehoach'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        // $query->andWhere(['<>', 'baoduongtong.TYPE', 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'kehoach', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]]);
        //, ['<>', 'baoduongtong.TYPE', 2]
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

    public function searchDskh($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'kehoach'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['<>', 'baoduongtong.TYPE', 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'kehoach', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['<>', 'baoduongtong.TYPE', 2]]);
        
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
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'dangthuchien', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['<>', 'baoduongtong.TYPE', 2]]);
        
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


    public function searchDskq($params)
    {
        $query = Dotbaoduong::find()->where(['or', ['dotbaoduong.TRANGTHAI' => 'ketthuc'], ['dotbaoduong.TRANGTHAI' => 'chuahoanthanh'], ['dotbaoduong.TRANGTHAI' => 'chuathuchien']])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['<>', 'baoduongtong.TYPE', 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'ketthuc', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['<>', 'baoduongtong.TYPE', 2]]);
        
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


    public function searchKtntkh($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'kehoach'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['baoduongtong.TYPE' => 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'kehoach', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['baoduongtong.TYPE' => 2]]);
        
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

    public function searchKtntth($params)
    {
        $query = Dotbaoduong::find()->where(['dotbaoduong.TRANGTHAI' => 'dangthuchien' ])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['baoduongtong.TYPE' => 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'dangthuchien', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['baoduongtong.TYPE' => 2]]);
        
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


    public function searchKtntkq($params)
    {
        $query = Dotbaoduong::find()->where(['or', ['dotbaoduong.TRANGTHAI' => 'ketthuc'], ['dotbaoduong.TRANGTHAI' => 'chuahoanthanh'], ['dotbaoduong.TRANGTHAI' => 'chuathuchien']])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('nHANVIEN');
        $query->joinWith('baoduongtong');
        $query->andWhere(['baoduongtong.TYPE' => 2]);
        
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 5) {
            $query->andWhere(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $query->orWhere(['and', ['dotbaoduong.TRANGTHAI' => 'ketthuc', 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN], ['baoduongtong.TYPE' => 2]]);
        
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

}
