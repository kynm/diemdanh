<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Phieuthu;

/**
 * ActivitiesLogSearch represents the model behind the search form of `app\models\ActivitiesLog`.
 */
class PhieuthuSearch extends Phieuthu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MA_DONVIKT'], 'safe'],
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
        $query = Phieuthu::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_HOPDONG' => $params['ID_HOPDONG'],
        ]);

        return $dataProvider;
    }

    public function searchThongkephieuthu($params)
    {
        $query = Phieuthu::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('donvitheomaketoan');
        // grid filtering conditions
        if (Yii::$app->user->can('dmdv-diennhienlieu')) {
            $query->andFilterWhere(['phieuthu_csht.MA_DONVIKT' => Donvi::findone(Yii::$app->user->identity->nhanvien->ID_DONVI)->MA_DONVIKT]);
        }
        $query->andFilterWhere(['phieuthu_csht.MA_DONVIKT' => $this->MA_DONVIKT]);

        return $dataProvider;  
    }
}
