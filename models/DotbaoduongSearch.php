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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DOTBD'], 'integer'],
            [['MA_DOTBD', 'TRANGTHAI'], 'string', 'max' => 32],
            [['MA_DOTBD', 'NGAY_BD', 'ID_TRAMVT', 'TRUONG_NHOM'], 'safe'],
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
        $query = Dotbaoduong::find()->orderBy(['NGAY_BD' => SORT_ASC]);

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
        $query->joinWith('tRUONGNHOM');
        // $query->joinWith('baocao');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAMVT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->TRUONG_NHOM]);

        return $dataProvider;
    }

    public function searchDskh($params)
    {
        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kế hoạch'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('tRUONGNHOM');
        
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
            $query->andWhere(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        
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
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAMVT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->TRUONG_NHOM]);

        return $dataProvider;
    }

    public function searchDsth($params)
    {
        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Đang thực hiện' ])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('tRUONGNHOM');
        
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
            $query->andWhere(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }

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
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAMVT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->TRUONG_NHOM]);

        return $dataProvider;
    }


    public function searchDskq($params)
    {
        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kết thúc'])->orderBy(['NGAY_BD' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith('tRAMVT');
        $query->joinWith('tRAMVT.iDDAI');
        $query->joinWith('tRUONGNHOM');
        
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
            $query->andWhere(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }

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
        $query->joinWith('tRUONGNHOM');
        // $query->joinWith('baocao');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_DOTBD' => $this->ID_DOTBD,
            'NGAY_BD' => $this->NGAY_BD,
            'TRANGTHAI' => $this->TRANGTHAI,
        ]);

        $query->andFilterWhere(['like', 'MA_DOTBD', $this->MA_DOTBD])
            ->andFilterWhere(['like', 'tramvt.MA_TRAM', $this->ID_TRAMVT])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->TRUONG_NHOM]);

        return $dataProvider;
    }


}
