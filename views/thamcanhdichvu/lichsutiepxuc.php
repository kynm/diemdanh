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

$this->title = 'LỊCH SỬ TIẾP XÚC KHÁCH HÀNG';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'],
                        [
                            'attribute' => 'khachhanggh_id',
                            'value' => 'khachhang.TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'nhanvien_id',
                            'value' => 'nhanvien.TEN_NHANVIEN'
                        ],
                        'ngay_tiepxuc',
                        [
                            'attribute' => 'ht_tc',
                            'value' => function ($model) {
                                return hinhthuctx()[$model->ht_tc];
                            }
                        ],
                        [
                            'attribute' => 'ds_dichvu',
                            'value' => function ($model) {
                                return $model->dichvutuvan;
                            }
                        ],
                        [
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return $model->dichvuphattrien;
                            }
                        ],
                        [
                            'attribute' => 'ghichu',
                            'value' => function ($model) {
                                return '<textarea>' . $model->ghichu . '</textarea>';
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>