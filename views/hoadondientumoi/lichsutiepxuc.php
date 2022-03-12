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

$this->title = 'Điều hành chiến dịch HDDT mới';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <p>
        <?= (Yii::$app->user->can('import-dshddtmoi')) ? Html::a('<i class="fa fa-plus"></i> Import dữ liệu', ['import'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
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
                            'attribute' => 'donvi_id',
                            'value' => 'khachhang.donvi.TEN_DONVI',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'hddtmoi_id',
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
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return ketquatxhoadon()[$model->ketqua];
                            }
                        ],
                        'ghichu',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>