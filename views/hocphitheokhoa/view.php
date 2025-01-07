<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = $model->TIEUDE;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['quanlyhocphi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quanlyhocphi-view">
    <p>
    <?= Html::a('<i class="fa fa-arrow-left"></i> Quay lại', ['/hocphitheokhoa/index'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?php if (Yii::$app->user->can('quanlyhocphi') && !$model->getChitiethocphi()->where(['STATUS' => 2])->count()):?>
        <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
    <?= Html::a('<i class="fa fa-print"></i> In theo lớp', ['/hocphitheokhoa/inhocphitheolop', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
    <!-- <?= Html::a('<i class="fa fa-file-pdf-o"></i> Export Pdf', ['/hocphitheokhoa/exportpdf', 'id' => $model->ID], ['class' => 'btn btn-success btn-flat', 'target' => '_blank']) ?> -->
    <?php if (Yii::$app->user->can('quanlyhocphi')):?>
    <span class="pull-right btn btn-warning bosunghocsinh" data-id="<?= $model->ID?>">TẠO HỌC PHÍ</span>
    <?php endif; ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_LOP',
                        'value' => $model->lop ?  Html::a($model->lop->TEN_LOP, ['/lophoc/view', 'id' => $model->lop->ID_LOP]) : '',
                        'format' => 'raw',
                    ],
                    'TIEUDE',
                    'DEN_NGAY',
                    [
                        'attribute' => 'TU_NGAY',
                        'value' => '<input type="date" name ="HOCPHITHEOKHOA_TU_NGAY" value="' . $model->TU_NGAY . '" class="form-control" data-id="' . $model->ID  . '">',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'DEN_NGAY',
                        'value' => '<input type="date" name ="HOCPHITHEOKHOA_DEN_NGAY" value="' . $model->DEN_NGAY . '" class="form-control" data-id="' . $model->ID  . '">',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SO_BUOI_DAHOC',
                        'value' => Html::a($model->soluongdadiemdanh . '/ ' . $model->SO_BH, ['/lophoc/quanlydiemdanhnew', 'id' => $model->ID_LOP, 'TU_NGAY' => $model->TU_NGAY, 'DEN_NGAY' => $model->DEN_NGAY], ['class' => 'text text-primary', 'target' => '_blank']),
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="box-body table-responsive">
    <h4 class="text-center text-success invisible text-alert">Xác nhận thành công</h4>
    <table class="table table-bordered" style="font-size: 14px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center" style="width: 10px">#</th>
                <th class="text-center">HỌC SINH</th>
                <th class="text-center">SỐ BUỔI ĐÃ HỌC</th>
                <th class="text-center">SỐ BUỔI</th>
                <th class="text-center">TIỀN HỌC</th>
                <th class="text-center">MIỄN GIẢM/ HỌC BỔNG</th>
                <th class="text-center">TỪ NGÀY</th>
                <th class="text-center">ĐẾN NGÀY</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->getChitiethocphi()->orderBy(['STATUS' => SORT_ASC])->all() as $key => $chitiet):?>
                <?php if (Yii::$app->user->can('quanlyhocphi') && $chitiet->STATUS == 1):?>
                <tr>
                    <td scope="col"><?= $key + 1;?></td>
                    <td><?= $chitiet->hocsinh ? $chitiet->hocsinh->HO_TEN . ($chitiet->hocsinh->STATUS ? '' : '(ĐÃ NGHỈ)') : 'HỌC SINH KHÔNG TỒN TẠI'?></td>
                        <td><?= Html::a($chitiet->sobuoidahoc($chitiet->NGAY_BD, $chitiet->NGAY_KT) . '/' . $chitiet->SO_BH, ['/hocsinh/lichsudiemdanh', 'id' => $chitiet->hocsinh->ID, 'TU_NGAY' => $chitiet->NGAY_BD, 'DEN_NGAY' => $chitiet->NGAY_KT], ['class' => 'text text-primary', 'target' => '_blank'])?></td>
                    <td><input class="form-control capnhatsobuoihoc" name="SO_BH" type="number" value="<?= $chitiet->SO_BH?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhatsotien" type="number" name="SOTIEN" value="<?= $chitiet->SOTIEN?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhatmiengiam" type="number" name="TIENGIAM" value="<?= $chitiet->TIENGIAM?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhatngaybd" type="date" name ="NGAY_BD" value="<?= $chitiet->NGAY_BD?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><?= Yii::$app->formatter->asDatetime($chitiet->NGAY_KT, 'php:d/m/Y')?></td>
                    <td><input class="form-control capnhattienkhac" type="number" name ="TIENKHAC" value="<?= $chitiet->TIENKHAC?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhattongtien" id="TONGTIEN-<?= $chitiet->ID ?>" type="number" value="<?= $chitiet->TONGTIEN?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td width="15%"><textarea class="form-control capnhatghichu" name="GHICHU" data-id="<?= $chitiet->ID ?>"><?= $chitiet->GHICHU?></textarea></td>
                    <td width="5%">
                        <?= Html::a('<i class="fa fa-print"></i> In', ['/quanlyhocphithutruoc/inchitiet', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
                        <?php if (Yii::$app->user->can('quanlyhocphi') && $chitiet->STATUS == 1):?>
                            <span class="btn btn-flat btn-warning duyetthuphitruoc" data-id="<?= $chitiet->ID ?>">Xác nhận thu tiền</span>
                            <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['deletechitiet', 'id' => $chitiet->ID], [
                                'class' => 'btn btn-danger btn-flat',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Dữ liệu sẽ bị xóa vĩnh viễn không thể khôi phục lại.Bạn chắc chắn muốn xóa mục này?'),
                                    'method' => 'post',
                                ],
                            ])?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php else: ?>
                    <tr>
                        <td scope="col"><?= $key + 1;?></td>
                        <td><?= $chitiet->hocsinh ? $chitiet->hocsinh->HO_TEN : 'HỌC SINH KHÔNG TỒN TẠI'?></td>
                        <td><?= Html::a($chitiet->sobuoidahoc($chitiet->NGAY_BD, $chitiet->NGAY_KT) . '/' . $chitiet->SO_BH, ['/hocsinh/lichsudiemdanh', 'id' => $chitiet->hocsinh->ID, 'TU_NGAY' => $chitiet->NGAY_BD, 'DEN_NGAY' => $chitiet->NGAY_KT], ['class' => 'text text-primary', 'target' => '_blank'])?></td>
                        <td><?= number_format($chitiet->SO_BH)?></td>
                        <td><?= number_format($chitiet->SOTIEN)?></td>
                        <td><?= number_format($chitiet->TIENGIAM)?></td>
                        <td><?= $chitiet->NGAY_BD?></td>
                        <td><?= $chitiet->NGAY_KT?></td>
                        <td><?= number_format($chitiet->TIENKHAC)?></td>
                        <td><?= number_format($chitiet->TONGTIEN)?></td>
                        <td width="15%"><?= nl2br($chitiet->GHICHU)?></td>
                        <td width="5%">
                            <?= Html::a('<i class="fa fa-print"></i> In', ['/quanlyhocphithutruoc/inchitiet', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
                            <?php if (Yii::$app->user->can('quanlyhocphi') && $chitiet->STATUS == 2):?>
                                <span class="btn btn-danger modieuchinh" data-id="<?= $chitiet->ID ?>">Mở điều chỉnh</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
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
        var capnhatghichu = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/hocphitheokhoa/capnhatghichu',
            method: 'post',
            data: {
                id: id,
                capnhatghichu: capnhatghichu,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $(document).on('click', '.bosunghocsinh', function() {
        Swal.fire({
            title: 'Bạn có muốn bổ sung toàn bộ học sinh của lớp vào danh sách thu học phí không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'CÓ!',
            cancelButtonText: "KHÔNG XÓA!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            Swal.fire("HỆ THỐNG ĐANG XỬ LÝ DỮ LIỆU, VUI LÒNG CHỜ TRONG GIÂY LÁT!");
            $.ajax({
                url: '/hocphitheokhoa/bosunghocsinh',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Bổ sung thành công!');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 800);
                    }
                }
            });
        }
        });
    });

    $(document).on('change', '.capnhattienkhac', function() {
        var tienkhac = $(this).val();
        var id = $(this).data('id');
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
                    $('#TONGTIEN-' + data.data.ID).val(data.data.TONGTIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $(document).on('change', '.capnhatmiengiam', function() {
        var miengiam = $(this).val();
        var id = $(this).data('id');
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
                    $('#TONGTIEN-' + data.data.ID).val(data.data.TONGTIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $(document).on('change', 'input[name=HOCPHITHEOKHOA_DEN_NGAY]', function() {
        var id = $(this).data('id');
        var ngaykt = $(this).val();
        $.ajax({
            url: '/hocphitheokhoa/thaydoingaykt',
            method: 'post',
            data: {
                id: id,
                ngaykt: ngaykt,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('THAY ĐỔI THÀNH CÔNG');
                        setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });

    $(document).on('change', 'input[name=HOCPHITHEOKHOA_TU_NGAY]', function() {
        var id = $(this).data('id');
        var ngaybd = $(this).val();
        $.ajax({
            url: '/hocphitheokhoa/thaydoingaybd',
            method: 'post',
            data: {
                id: id,
                ngaybd: ngaybd,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('THAY ĐỔI THÀNH CÔNG');
                        setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    Swal.fire('LỖI CẬP NHẬT!');
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>