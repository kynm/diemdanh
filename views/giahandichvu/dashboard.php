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

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="giahandichvu-index">
    <div class="box box-primary">
        <?= $this->render('_table_ketqua', ['tendv' => 'KẾT QUẢ GIA  HẠN DỊCH VỤ VNPT-CA', 'data' => $dsketquagiahanca,]) ?>
        <?= $this->render('_table_ketqua', ['tendv' => 'KẾT QUẢ GIA  HẠN DỊCH VỤ VNPT-IVAN', 'data' => $dsketquagiahanivan,]) ?>
        <?= $this->render('_table_ketqua', ['tendv' => 'KẾT QUẢ GIA  HẠN DỊCH VỤ HĐĐT', 'data' => $dsketquagiahanhddt,]) ?>
        <?= $this->render('_table_ketqua', ['tendv' => 'KẾT QUẢ GIA  HẠN DỊCH VỤ CNTT KHÁC', 'data' => $dsketquagiahandvkhac,]) ?>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3><b class="text text-danger">LỊCH SỬ TIẾP XÚC KHÁCH HÀNG</b></h3>
                </div>
                <div class="box-body">
                    <?php Pjax::begin(); ?><?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'rowOptions' => function ($model, $index, $widget, $grid){
                              return ['style'=>'color:'. colorgiahan($model) .';'];
                            },
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'MST',
                                    'value' => 'MST',
                                ],
                                [
                                    'attribute' => 'khachhanggh_id',
                                    'value' => 'TEN_KH',
                                    'contentOptions' => ['style' => 'width:10%'],
                                ],
                                [
                                    'attribute' => 'nhanvien_id',
                                    'value' => 'nhanvien.TEN_NHANVIEN',
                                    'filter'=> $dsNhanvien,
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'options' => ['prompt' => ''],
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                ],
                                [
                                    'contentOptions' => ['style' => 'width:10%'],
                                    'attribute' => 'DICHVU_ID',
                                    'value' => 'dichvu.ten_dv',
                                    'filter'=> $dsDichvu,
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'options' => ['prompt' => ''],
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                ],
                                [
                                    'attribute' => 'ghichu',
                                    'value' => function ($model) {
                                        return $model->ghichu;
                                    },
                                    // 'contentOptions' => ['style' => 'width:20%'],
                                    'format' => 'raw',
                                ],
                                ['attribute'=>'NGAY_HH',
                                    'value' => function ($model) {
                                        return Yii::$app->formatter->asDatetime($model->NGAY_HH, 'php:d-m-Y');
                                    },
                                ],
                                ['attribute'=>'ngay_lh',
                                    'value' => function ($model) {
                                        return Yii::$app->formatter->asDatetime($model->ngay_lh, 'php:d-m-Y');
                                    },
                                ],
                                [
                                    'attribute' => 'ketqua',
                                    'value' => function ($model) {
                                        return $model->ketqua ? ketquagiahan()[$model->ketqua] : 'Chưa liên hệ';
                                    }
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>