<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tramvt;
use app\models\Thietbitram;
use app\models\Thietbi;
use yii\helpers\ArrayHelper;

/**
 * TramvtSearch represents the model behind the search form about `app\models\Tramvt`.
 */
class TramvtSearch extends Tramvt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_TRAM'], 'integer'],
            [['MA_TRAM', 'TEN_TRAM', 'DIADIEM', 'ID_DAI', 'ID_NHANVIEN'], 'safe'],
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
        $query = Tramvt::find();

        // add conditions that should always apply here
        // if (Yii::$app->user->identity->nhanvien->chucvu->cap == 2) {
            
        // }
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $query->andWhere(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap == 3) {
            $query->andWhere(['tramvt.ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI]);
        }
        if (Yii::$app->user->identity->nhanvien->chucvu->cap >= 4) {
            $query->andWhere(['tramvt.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
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

        $query->joinWith('iDDAI');
        $query->joinWith('iDNHANVIEN');

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_TRAM' => $this->ID_TRAM,
        ]);

        $query->andFilterWhere(['like', 'MA_TRAM', $this->MA_TRAM])
            ->andFilterWhere(['like', 'daivt.TEN_DAIVT', $this->ID_DAI])
            ->andFilterWhere(['like', 'TEN_TRAM', $this->TEN_TRAM])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN])
            ->andFilterWhere(['like', 'DIADIEM', $this->DIADIEM]);

        return $dataProvider;
    }

    public function searchMayno($params)
    {
        $allIdsTramMayno = ArrayHelper::map(Thietbitram::find()
            ->where(['in', 'ID_LOAITB', ArrayHelper::map(Thietbi::find()->where(['in', 'ID_NHOM', 1])->all(), 'ID_THIETBI', 'ID_THIETBI')])
            ->all(), 'ID_TRAM', 'ID_TRAM');
        $query = Tramvt::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('iDDAI');
        $query->joinWith('iDNHANVIEN');

        $query->andFilterWhere([
            'ID_TRAM' => $this->ID_TRAM,
        ]);

        $query->andFilterWhere(['=', 'daivt.ID_DAI', $this->ID_DAI])
            ->andFilterWhere(['in', 'ID_TRAM', $allIdsTramMayno])
            ->andFilterWhere(['like', 'TEN_TRAM', $this->TEN_TRAM]);
        $query->orderBy(['TEN_TRAM' => SORT_ASC]);

        return $dataProvider;
    }

    public function searchQldien($params)
    {
        $query = Tramvt::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
        }
        $query->joinWith('iDDAI');
        $query->joinWith('iDNHANVIEN');
        $query->andFilterWhere([
            'ID_TRAM' => $this->ID_TRAM,
        ]);
        $query->andFilterWhere(['=', 'daivt.ID_DAI', $this->ID_DAI])
            ->andFilterWhere(['in', 'daivt.ID_DONVI', $iddv])
            ->andFilterWhere(['like', 'TEN_TRAM', $this->TEN_TRAM]);

        return $dataProvider;
    }

    public function searchQlhopdong($params)
    {
        $query = Tramvt::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
        if (Yii::$app->user->can('dmdv-qlhopdong')) {
            $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
        }
        $query->joinWith('iDDAI');
        $query->joinWith('iDNHANVIEN');
        $query->andFilterWhere([
            'ID_TRAM' => $this->ID_TRAM,
        ]);
        $query->andFilterWhere(['=', 'daivt.ID_DAI', $this->ID_DAI])
            ->andFilterWhere(['in', 'daivt.ID_DONVI', $iddv])
            ->andFilterWhere(['like', 'TEN_TRAM', $this->TEN_TRAM]);

        return $dataProvider;
    }
}
