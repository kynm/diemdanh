<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Quản lý học phí';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý học phí', 'url' => ['quanlyhocphi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/partial/_header_quanlyhocphi', []) ?>
<div class="quanlyhocphi-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:20%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->hocphi->TIEUDE;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_LOP',
                                'value' => 'hocphi.lop.TEN_LOP',
                                'contentOptions' => ['style' => 'width:10%;white-space: normal;word-break: break-word;word-break: break-word'],
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'value' => 'hocsinh.HO_TEN',
                            ],
                            'SO_BH',
                            'SO_BDH',
                            'SO_BN',
                            'SO_BTT',
                            [
                                'attribute' => 'TIENHOC',
                                'value' => function ($model) {
                                    return number_format($model->TIENHOC);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIENKHAC',
                                'value' => function ($model) {
                                    return number_format($model->TIENKHAC);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONG_TIEN',
                                'value' => function ($model) {
                                    return number_format($model->TONG_TIEN);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'STATUS',
                                'value' => function ($model) {
                                    return $model->STATUS ? '<span class="btn btn-flat btn-success">Đã thu</span>' : '<span class="btn btn-flat btn-danger">Chưa thu</span>';
                                },
                                'filter'=> statusthutien(),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => Yii::$app->user->can('quanlyhocphi') ? '{xacnhanthuhocphi}{print}{delete}' : '{print}',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return $model->STATUS == 1 ? Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                                            'class' => 'btn btn-danger btn-flat',
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Dữ liệu sẽ bị xóa vĩnh viễn không thể khôi phục lại.Bạn chắc chắn muốn xóa mục này?'),
                                                'method' => 'post',
                                            ],
                                        ]) : null;
                                    },
                                    'xacnhanthuhocphi' => function ($url, $model) {
                                        return $model->STATUS == 0 ? '<span class="btn btn-warning xacnhanthuhocphi" data-id="' . $model->ID . '">Xác nhận thu tiền</span>' : '<span class="btn btn-danger modieuchinh" data-id="' . $model->ID . '">Mở điều chỉnh</span>';
                                    },
                                    'print' => function ($url, $model) {
                                        return Html::a('<i class="fa fa-print"></i>', ['/quanlyhocphi/chitiethocphi', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']);
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
<?php
$script = <<< JS
    $(document).on('click', '.xacnhanthuhocphi', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn đã thu học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'ĐÃ THU!',
            cancelButtonText: "CHƯA THU!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphi/xacnhanthuhocphi',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Xác nhận thành công');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1000);
                    }
                }
            });
        }
        });
    });

    $(document).on('click', '.modieuchinh', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn chưa thu học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'ĐÃ THU!',
            cancelButtonText: "CHƯA THU!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphi/modieuchinh',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Xác nhận thành công');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1000);
                    }
                }
            });
        }
        });
    });

    $(document).on('click', '.xoaluotthuhocphi', function() {
        Swal.fire({
            title: 'Thao tác này sẽ xóa vĩnh viễn dữ liệu.Bạn có chắc chắn muốn xóa học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'CÓ, xÓA NGAY!',
            cancelButtonText: "KHÔNG XÓA!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphi/xoaluotthuhocphi',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Xác nhận thành công');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1000);
                    }
                }
            });
        }
        });
    });
JS;
$this->registerJs($script);
?>