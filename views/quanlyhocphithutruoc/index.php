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
        <?= $this->render('/partial/_header_hocphithutruoc', []) ?>
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
                                'contentOptions' => ['style' => 'width:5%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    $hoten = $model->hocsinh ? $model->hocsinh->HO_TEN : 'Không tìm thấy học sinh';
                                    return $model->STATUS == 1 ? $hoten . ($model->hocsinh->STATUS ? '' : '(ĐÃ NGHỈ)') : $hoten;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOTIEN',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="number" id="SOTIEN-' . $model->ID . '" name="SOTIEN" class="form-control" value="' . $model->SOTIEN . '" data-id="' . $model->ID  . '">' : $model->SOTIEN;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SO_BH',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="number" id="SO_BH-' . $model->ID . '" name="SO_BH" class="form-control" value="' . $model->SO_BH . '" data-id="' . $model->ID  . '">' : $model->SO_BH;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIENKHAC',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="number" id="TIENKHAC-' . $model->ID . '" name="TIENKHAC" class="form-control" value="' . $model->TIENKHAC . '" data-id="' . $model->ID  . '">' : $model->TIENKHAC;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIENGIAM',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="number" id="TIENGIAM-' . $model->ID . '" name="TIENGIAM" class="form-control capnhatmiengiam" value="' . $model->TIENGIAM . '" data-id="' . $model->ID  . '">' : $model->TIENGIAM;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIEN',
                                'contentOptions' => ['style' => 'width:6%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return '<span id="TONGTIEN-' . $model->ID . '">' . number_format($model->TONGTIEN) . '</span>';
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_BD',
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="date" name ="NGAY_BD" value="' . $model->NGAY_BD . '" class="form-control" data-id="' . $model->ID  . '">' : ($model->NGAY_BD ? Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y') : NULL);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_KT',
                                'value' => function($model) {
                                    return $model->STATUS == 1 ? '<input type="date" name="NGAY_KT" id="NGAY_KT_' . $model->ID . '" value="' . $model->NGAY_KT . '" class="form-control" data-id="' . $model->ID  . '">' : ($model->NGAY_KT ? Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y') : NULL);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return '<textarea class="form-control capnhatghichu" data-id="' .  $model->ID . '">' . $model->GHICHU . '</textarea>';
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
                                'template' => Yii::$app->user->can('quanlyhocphi') ? '{duyetthuphitruoc}{delete}{print}' : '{print}',
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
                    var sobh = data.sobh;
                    var tu_ngay = data.tu_ngay;
                    var lopid = data.lopid;
                    var idhptt = data.ID;
                    if (sobh && tu_ngay && lopid) {
                       $.ajax({
                            url: '/quanlyhocphithutruoc/tinhngayketthuc',
                            method: 'post',
                            data: {
                                'lopid' : lopid,
                                'sobh' : sobh,
                                'ngay_bd' : tu_ngay,
                            },
                            success:function(data) {
                                data = jQuery.parseJSON(data);
                                if (!data.error) {
                                    $("#NGAY_KT_" + idhptt).val(data.NGAY_KT);
                                } else {
                                    Swal.fire(data.message);
                                }
                            }
                        }); 
                    }
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

    $(document).on('change', 'input[name=TIENGIAM]', function() {
        var miengiam = $(this).val();
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '/quanlyhocphithutruoc/thaydoimiengiam',
            method: 'post',
            data: {
                id: id,
                miengiam: miengiam,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#TONGTIEN-' + data.data.ID).html(data.data.TONGTIEN);
        console.log(data.data.ID);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>
