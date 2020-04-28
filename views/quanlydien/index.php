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

$this->title = 'Điều hành điện theo trạm';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <p>
        <?= (Yii::$app->user->can('Administrator')) ? Html::a('<i class="fa fa-plus"></i> Import dữ liệu', ['import'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
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
                                'template' => '{update}',
                                'buttons' => [
                                    'update' => function ($url,$model) {
                                        if ($model->MA_DIENLUC) {
                                            $url = Url::to(['quanlydien/nhapdulieudien', 'MA_DIENLUC' => $model->MA_DIENLUC]);
                                            return Html::a('<span class="glyphicon glyphicon-pencil"> </span>', $url, ['title' => 'Điều chỉnh nội dung' ]);
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
