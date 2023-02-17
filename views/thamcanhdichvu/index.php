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

$this->title = 'DANH SÁCH GIA HẠN DỊCH VỤ';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <p>
        <?php if(Yii::$app->user->can('Administrator')): ?>
        <?= (Yii::$app->user->can('import-dshddtmoi')) ? Html::a('<i class="fa fa-plus"></i> Import dữ liệu', ['import'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
        <?php endif; ?>
        <?= Html::a('Lịch sử tiếp xúc', ['lichsutiepxuc'], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Excel', ['excellichsutiepxuc'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $index, $widget, $grid){
                      return ['style'=>'color:'. colorketqua($model->ketqua) .';'];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'],
                        [
                            'attribute' => 'TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'MST',
                        [
                            'attribute' => 'DIACHI',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        [
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'attribute' => 'DICHVU_ID',
                            'value' => 'dichvu.ten_dv',
                            'filter'=> $dsDichvu,
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                        ],
                        'LIENHE',
                        'NGAY_HH',
                        [
                            'attribute' => 'ghichu',
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return $model->ketqua ? $model->dichvuphattrien : 'Chưa liên hệ';
                            }
                        ],
                        [
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'attribute' => 'nhanvien_id',
                            'value' => 'nhanvien.TEN_NHANVIEN',
                            'filter'=> $dsNhanvien,
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                        ],
                        'ngay_lh',
                        
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>