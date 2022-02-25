<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    // 'formatter' => [
                    //     'class' => 'yii\i18n\Formatter',
                    //     'nullDisplay' => '',
                    // ],
                    'rowOptions' => function ($model, $index, $widget, $grid){
                      return ['style'=>'color:'. colorstatus($model->status) .';'];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'ngay_bh',
                        'ten_kh',
                        'ma_tb',
                        'diachi',
                        'so_dt',
                        [
                            'attribute' => 'status',
                            'filter'=> statusbaohong(),
                            'value' => 'tentrangthai'
                        ],
                        'ngay_xl',
                        [
                            'attribute' => 'nhanvien_xl_id',
                            'value' => 'nHANVIENXULY.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'nhanvien_id',
                            'value' => 'nHANVIEN.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'donvi_id',
                            'value' => 'iDDONVI.TEN_DONVI'
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>