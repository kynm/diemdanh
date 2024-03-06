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

$this->title = 'KHẢO SÁT DOANH NGHIỆP, KẾ TOÁN';
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
                        'template' => '{viewchitiet}',
                            'buttons' => [
                                'viewchitiet' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open">Chi tiết</span>', '/giahandichvu/view?id=' . $model->khachhanggh_id, [
                                        'title' => Yii::t('app', 'lead-update'),
                                    ]);
                                },
                            ],
                        ],
                        [
                            'attribute' => 'khachhanggh_id',
                            'value' => 'khachhang.TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        // [
                        //     'attribute' => 'nhanvien_id',
                        //     'value' => 'nhanvien.TEN_NHANVIEN'
                        // ],
                        'ngay_tiepxuc',
                        [
                            'attribute' => 'hotrokipthoi',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'giacuoc',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'khokhan',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'dnk_hotro',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'nhucau_hotro',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'noidung_canhotronhat',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'nhucau',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'ghichu',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        // [
                        //     'attribute' => 'ht_tc',
                        //     'value' => function ($model) {
                        //         return hinhthuctx()[$model->ht_tc];
                        //     }
                        // ],
                        // [
                        //     'attribute' => 'ketqua',
                        //     'value' => function ($model) {
                        //         return ketquagiahan()[$model->ketqua];
                        //     }
                        // ],
                        // [
                        //     'attribute' => 'ghichu',
                        //     'value' => function ($model) {
                        //         return '<textarea>' . $model->ghichu . '</textarea>';
                        //     },
                        //     'format' => 'raw',
                        // ],
                        // 'ghichu',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>