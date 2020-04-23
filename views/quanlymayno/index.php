<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điều hành điện/nhiên liệu theo trạm';
$this->params['breadcrumbs'][] = ['label' => 'Điều hành điện/nhiên liệu', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'ID_DAI',
                                'value' => 'iDDAI.TEN_DAIVT',
                                'filter'=>ArrayHelper::map(Daivt::find()->asArray()->all(), 'ID_DAI', 'TEN_DAIVT'),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'TEN_TRAM',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->TEN_TRAM;
                                },
                                'filter'=> $listTram,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{view}',
                                'buttons'=>[
                                ]  
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
