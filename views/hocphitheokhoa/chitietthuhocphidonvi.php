<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ HỌC PHÍ THU TRƯỚC';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= $this->render('/partial/_header_hocphitheokhoa', []) ?>
    </p>
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
                                'contentOptions' => ['style' => 'width:5%; white-space: normal;word-break: break-word;'],
                                'value' => 'TIEUDE',
                            ],
                            [
                                'attribute' => 'ID_LOP',
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'value' => 'lop.TEN_LOP',
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    $hoten = $model->hocsinh ? $model->hocsinh->HO_TEN : 'Không tìm thấy học sinh';
                                    return $model->STATUS == 1 ? Html::a($hoten . ($model->hocsinh->STATUS ? '' : '(ĐÃ NGHỈ)'), ['view', 'id' => $model->ID]) : $hoten;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOTIEN',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->SOTIEN;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SO_BH',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->SO_BH;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIENKHAC',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->TIENKHAC;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIEN',
                                'contentOptions' => ['style' => 'width:6%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return number_format($model->TONGTIEN);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_BD',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_KT',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return nl2br($model->GHICHU);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'STATUS',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return statusdonhang()[$model->STATUS];
                                },
                                'filter'=> statusdonhang(),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => Yii::$app->user->can('quanlyhocphi') ? '{duyetthuphitruoc}{print}' : '{print}',
                                'buttons' => [
                                    'duyetthuphitruoc' => function ($url, $model) {
                                        return $model->STATUS == 1 ? '<span class="btn btn-primary duyetthuphitruoc" data-id="' . $model->ID . '">Duyệt</span>' : '<span class="btn btn-danger modieuchinh" data-id="' . $model->ID . '">Mở điều chỉnh</span>';
                                    },
                                    'print' => function ($url, $model) {
                                        return Html::a('<i class="fa fa-print"></i>', ['/quanlyhocphithutruoc/inchitiet', 'id' => $model->ID], ['class' => 'btn btn-primary', 'target' => '_blank']);
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
    $(document).on('click', '.duyetthuphitruoc', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn đã thu học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'ĐÃ THU!',
            cancelButtonText: "CHƯA THU!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphithutruoc/duyetthuphitruoc',
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
            title: 'Bạn có chắc chắn mở lại để điều chỉnh học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'MỞ NGAY!',
            cancelButtonText: "KHÔNG!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphithutruoc/modieuchinh',
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
    $(document).on('change', 'input[name=SOTIEN]', function() {
        var id = $(this).data('id');
        var sotien = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoisotien',
            method: 'post',
            data: {
                id: id,
                sotien: sotien,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#SOTIEN-' + data.data.ID).val(data.data.SOTIEN);
                    $('#SO_BH-' + data.data.ID).val(data.data.SO_BH);
                    $('#TIENKHAC-' + data.data.ID).val(data.data.TIENKHAC);
                    $('#TONGTIEN-' + data.data.ID).html(data.data.TONGTIEN);
                    Swal.fire('Xác nhận thành công');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });

    $(document).on('change', 'input[name=SO_BH]', function() {
        var id = $(this).data('id');
        var so_bh = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoisobuoihoc',
            method: 'post',
            data: {
                id: id,
                so_bh: so_bh,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#SOTIEN-' + data.data.ID).val(data.data.SOTIEN);
                    $('#SO_BH-' + data.data.ID).val(data.data.SO_BH);
                    $('#TIENKHAC-' + data.data.ID).val(data.data.TIENKHAC);
                    $('#TONGTIEN-' + data.data.ID).html(data.data.TONGTIEN);
                    Swal.fire('Xác nhận thành công');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
    $(document).on('change', 'input[name=TIENKHAC]', function() {
        var id = $(this).data('id');
        var tienkhac = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoitienkhac',
            method: 'post',
            data: {
                id: id,
                tienkhac: tienkhac,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#SOTIEN-' + data.data.ID).val(data.data.SOTIEN);
                    $('#SO_BH-' + data.data.ID).val(data.data.SO_BH);
                    $('#TIENKHAC-' + data.data.ID).val(data.data.TIENKHAC);
                    $('#TONGTIEN-' + data.data.ID).html(data.data.TONGTIEN);
                    Swal.fire('Xác nhận thành công');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
    $(document).on('change', 'input[name=NGAY_BD]', function() {
        var id = $(this).data('id');
        var ngaybd = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoingaybd',
            method: 'post',
            data: {
                id: id,
                ngaybd: ngaybd,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('THAY ĐỔI THÀNH CÔNG');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
    $(document).on('change', 'input[name=NGAY_KT]', function() {
        var id = $(this).data('id');
        var ngaykt = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoingaykt',
            method: 'post',
            data: {
                id: id,
                ngaykt: ngaykt,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('THAY ĐỔI THÀNH CÔNG');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
    $(document).on('change', '.capnhatghichu', function() {
        var id = $(this).data('id');
        var ghichu = $(this).val();
        $.ajax({
            url: '/quanlyhocphithutruoc/capnhatghichu',
            method: 'post',
            data: {
                id: id,
                ghichu: ghichu,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('THAY ĐỔI THÀNH CÔNG');
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>
