<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý hợp đồng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-index">
        <p>
        <?= (Yii::$app->user->can('import-qlhopdong')) ? Html::a('<i class="fa fa-plus"></i> Import dữ liệu', ['import'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
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
                                'attribute' => 'ID_DONVI',
                                'value' => 'iDDAI.iDDONVI.TEN_DONVI',
                            ],
                            [
                                'attribute' => 'ID_DAI',
                                'value' => 'iDDAI.TEN_DAIVT',
                                'filter'=>ArrayHelper::map(Daivt::find()->where(['in', 'ID_DONVI', $iddv])->asArray()->all(), 'ID_DAI', 'TEN_DAIVT'),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            'MA_CSHT',
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
                                'template' => '{update}{view}',
                                'buttons' => [
                                    'update' => function ($url,$model) {
                                        if ($model->MA_CSHT) {
                                            $url = Url::to(['quanlyhopdong/nhaphopdong', 'MA_CSHT' => $model->MA_CSHT]);
                                            return Html::a('<span class="glyphicon glyphicon-pencil"> </span>', $url, ['title' => 'Quản lý hợp đồng' ]);
                                        }
                                        return '';
                                    },
                                    'view' => function ($url,$model) {
                                        if ($model->MA_CSHT) {
                                            $url = Url::to(['quanlyhopdong/view', 'MA_CSHT' => $model->MA_CSHT]);
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"> </span>', $url, ['title' => 'Quản lý hợp đồng' ]);
                                        }
                                        return '';
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
