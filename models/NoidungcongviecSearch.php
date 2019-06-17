<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Noidungcongviec;

/**
 * NoidungcongviecSearch represents the model behind the search form of `app\models\Noidungcongviec`.
 */
class NoidungcongviecSearch extends Noidungcongviec
{
    /**
     * @inheritdoc
     */
    public $ID_TRAM;
    public $ID_DAI;
    public $ID_DONVI;

    public function rules()
    {
        return [
            [['ID_DOTBD', 'ID_THIETBI', 'ID_NHANVIEN', 'MA_NOIDUNG', 'GHICHU', 'TRANGTHAI', 'KETQUA', 'ID_TRAM', 'ID_DAI', 'ID_DONVI'], 'safe'],
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
        $query = Noidungcongviec::find()->where(['noidungcongviec.ID_NHANVIEN' => 0]);

        // add conditions that should always apply here
        if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
            $query->andWhere(['donvi.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 50, 
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->joinWith('tHIETBI.iDLOAITB');
        $query->joinWith('dOTBD.tRAMVT.iDDAI.iDDONVI');
        $query->joinWith('mANOIDUNG');

        $query->andFilterWhere([
            'ID_NHANVIEN' => $this->ID_NHANVIEN,
        ]);

        $query
            ->andFilterWhere(['like', 'noidungbaotrinhomtbi.NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'noidungcongviec.TRANGTHAI', $this->TRANGTHAI])
            ->andFilterWhere(['like', 'KETQUA', $this->KETQUA])
            ->andFilterWhere(['like', 'dotbaoduong.MA_DOTBD', $this->ID_DOTBD])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'tramvt.TEN_TRAM', $this->ID_TRAM])
            ->andFilterWhere(['like', 'daivt.TEN_DAIVT', $this->ID_DAI])
            ->andFilterWhere(['like', 'donvi.TEN_DONVI', $this->ID_DONVI])
            ;

        return $dataProvider;
    }

    public function searchDbd($params)
    {
        $query = Noidungcongviec::find()->where(['ID_DOTBD'=>$_GET['id']])->orderBy(['noidungcongviec.TRANGTHAI' => SORT_ASC]);

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

        $query->joinWith('mANOIDUNG');
        $query->joinWith('tHIETBI.iDLOAITB');
        $query->joinWith('nHANVIEN');

        // grid filtering conditions

        $query
            ->andFilterWhere(['like', 'noidungbaotrinhomtbi.NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'nhanvien.TEN_NHANVIEN', $this->ID_NHANVIEN])
            ->andFilterWhere(['like', 'noidungcongviec.TRANGTHAI', $this->TRANGTHAI])
            ->andFilterWhere(['like', 'KETQUA', $this->KETQUA]);

        return $dataProvider;
    }

    public function searchPlan($params)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Noidungcongviec::find()->where(['noidungcongviec.ID_NHANVIEN'=> $nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => 'kehoach' ]);

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

        $query->joinWith('mANOIDUNG');
        $query->joinWith('tHIETBI.iDLOAITB');
        $query->joinWith('dOTBD');

        // grid filtering conditions

        $query
            ->andFilterWhere(['like', 'noidungbaotrinhomtbi.NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'dotbaoduong.MA_DOTBD', $this->ID_DOTBD])
            ->andFilterWhere(['like', 'noidungcongviec.TRANGTHAI', $this->TRANGTHAI])
            ->andFilterWhere(['like', 'KETQUA', $this->KETQUA]);

        return $dataProvider;
    }

    public function searchInProgress($params)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Noidungcongviec::find()->where(['noidungcongviec.ID_NHANVIEN'=> $nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => 'dangthuchien' ])->orderBy(['noidungcongviec.TRANGTHAI' => SORT_ASC]);

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

        $query->joinWith('mANOIDUNG');
        $query->joinWith('tHIETBI.iDLOAITB');
        $query->joinWith('dOTBD');

        // grid filtering conditions

        $query->andFilterWhere(['like', 'noidungbaotrinhomtbi.NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'dotbaoduong.MA_DOTBD', $this->ID_DOTBD])
            ->andFilterWhere(['like', 'noidungcongviec.TRANGTHAI', $this->TRANGTHAI])
            ->andFilterWhere(['like', 'KETQUA', $this->KETQUA]);

        return $dataProvider;
    }

    public function searchFinished($params)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Noidungcongviec::find()->where(['noidungcongviec.ID_NHANVIEN'=> $nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => 'ketthuc' ]);

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

        $query->joinWith('mANOIDUNG');
        $query->joinWith('tHIETBI.iDLOAITB');
        $query->joinWith('dOTBD');

        // grid filtering conditions

        $query->andFilterWhere(['like', 'noidungbaotrinhomtbi.NOIDUNG', $this->MA_NOIDUNG])
            ->andFilterWhere(['like', 'GHICHU', $this->GHICHU])
            ->andFilterWhere(['like', 'thietbi.TEN_THIETBI', $this->ID_THIETBI])
            ->andFilterWhere(['like', 'dotbaoduong.MA_DOTBD', $this->ID_DOTBD])
            ->andFilterWhere(['like', 'noidungcongviec.TRANGTHAI', $this->TRANGTHAI])
            ->andFilterWhere(['like', 'KETQUA', $this->KETQUA]);

        return $dataProvider;
    }


}
