<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
$this->title = $model->TIEUDE;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['quanlyhocphi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quanlyhocphi-view">
    <p>
    <?= Html::a('<i class="fa fa-arrow-left"></i> Quay lại', ['/quanlyhocphi/index'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?php if (Yii::$app->user->can('quanlyhocphi') && !$model->getChitiethocphi()->where(['STATUS' => 1])->count()):?>
        <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
    <?= Html::a('<i class="fa fa-print"></i> In theo lớp', ['/quanlyhocphi/inhocphitheolop', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
    <?= Html::a('<i class="fa fa-file-pdf-o"></i> Export Pdf', ['/quanlyhocphi/exportpdf', 'id' => $model->ID], ['class' => 'btn btn-success btn-flat', 'target' => '_blank']) ?>
    <?php if (Yii::$app->user->can('capnhatdadonghocphicalop')):?>
    <span class="pull-right btn btn-danger capnhatdadonghochocphitoanlop" data-id="<?= $model->ID?>">Cập nhật đã đóng học phí cả lớp</span>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlyhocphi')):?>
    <span class="pull-right btn btn-warning bosunghocsinh" data-id="<?= $model->ID?>">Bổ sung HS</span>
    <?php endif; ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_LOP',
                        'value' => $model->lop ? $model->lop->TEN_LOP : '',
                    ],
                    'TIEUDE',
                    'TU_NGAY',
                    'DEN_NGAY',
                    [
                        'attribute' => 'TIENHOC',
                        'value' => Yii::$app->user->can('hocphithangchung') ? '<input id="capnhattienhocchungtoanlop" class="form-control" data-id="' . $model->ID . '" type="number" value="' . $model->TIENHOC . '">' : '',
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
<?php if (Yii::$app->user->can('quanlyhocphi') && !$model->getChitiethocphi()->where(['STATUS' => 1])->count()):?>
<?= $this->render('_form_updatealldata', [
    'model' => $model,
    'inputs' => isset($inputs) ?? [],
]) ?>
<?php endif; ?>
<div class="box-body table-responsive">
    <h4 class="text-center text-success invisible text-alert">Xác nhận thành công</h4>
    <table class="table table-bordered" style="font-size: 14px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center" style="width: 10px">#</th>
                <th class="text-center">HỌC SINH</th>
                <th class="text-center">TỔNG SỐ BUỔI</th>
                <th class="text-center">SỐ BUỔI NGHỈ</th>
                <th class="text-center">NGÀY NGHỈ</th>
                <th class="text-center">SỐ BUỔI ĐI HỌC</th>
                <th class="text-center">NGÀY ĐI HỌC</th>
                <th class="text-center">SỐ TIỀN MỖI BUỔI</th>
                <th class="text-center">SỐ BUỔI TÍNH TIỀN</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->getChitiethocphi()->orderBy(['STATUS' => SORT_ASC])->all() as $key => $chitiet):
                ?>
                <tr>
                    <td scope="col"><?= $key + 1;?></td>
                    <td><?= $chitiet->hocsinh ? $chitiet->hocsinh->HO_TEN .  ($chitiet->hocsinh->STATUS ? '' : '(ĐÃ NGHỈ)') : 'HỌC SINH KHÔNG TỒN TẠI'?></td>
                    <td width="5%"><?= $chitiet->SO_BH?></td>
                    <td width="5%"><?= $chitiet->SO_BN?></td>
                    <td width="5%"><?= $chitiet->NGAY_NGHI?></td>
                    <td width="5%"><?= $chitiet->SO_BDH?></td>
                    <td width="10%"><?= $chitiet->NGAYDIHOC?></td>
                    <td><input class="form-control capnhatsotienmoibuoi" type="number" value="<?= $chitiet->TIENHOC?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhatsobuoitinhtien" type="number" value="<?= $chitiet->SO_BTT?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhattienkhac" type="number" value="<?= $chitiet->TIENKHAC?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhattongtien" id="tongtien-<?= $chitiet->ID ?>" type="number" value="<?= $chitiet->TONG_TIEN?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td width="15%"><textarea class="form-control capnhatghichu" data-id="<?= $chitiet->ID ?>"><?= $chitiet->NHAN_XET?></textarea></td>
                    <td width="5%">
                        <?= Html::a('<i class="fa fa-print"></i> In', ['/quanlyhocphi/chitiethocphi', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
                        <?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf', ['/quanlyhocphi/exportpdfchitiet', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
                        <?php if (Yii::$app->user->can('quanlyhocphi') && !$chitiet->STATUS):?>
                            <span class="btn btn-flat btn-warning xacnhanthuhocphi" data-id="<?= $chitiet->ID ?>">Xác nhận thu tiền</span>
                            <span class="btn btn-flat btn-danger xoaluotthuhocphi" data-id="<?= $chitiet->ID ?>">Xóa</span>
                        <?php else: ?>
                            <span class="btn btn-danger modieuchinh" data-id="<?= $chitiet->ID ?>">Mở điều chỉnh</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$script = <<< JS
$('.capnhatsotienmoibuoi').on('change', function() {
        var sotienmoibuoi = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhatsotienmoibuoi',
            method: 'post',
            data: {
                id: id,
                sotienmoibuoi: sotienmoibuoi,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#tongtien-' + data.ID).val(data.TONG_TIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });
    $('.capnhatsobuoitinhtien').on('change', function() {
        var sobuoi = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhatsobuoitinhtien',
            method: 'post',
            data: {
                id: id,
                sobuoi: sobuoi,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#tongtien-' + data.ID).val(data.TONG_TIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $('.capnhattienkhac').on('change', function() {
        var tiencongthem = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhattienkhac',
            method: 'post',
            data: {
                id: id,
                tiencongthem: tiencongthem,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#tongtien-' + data.ID).val(data.TONG_TIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $('.capnhattongtien').on('change', function() {
        var tongtien = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhattongtien',
            method: 'post',
            data: {
                id: id,
                tongtien: tongtien,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    $('#tongtien-' + data.ID).val(data.TONG_TIEN);
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $('.capnhatghichu').on('change', function() {
        var capnhatghichu = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhatghichu',
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

    $('.xacnhanthuhocphi').on('click', function() {
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
                        }, 800);
                    }
                }
            });
        }
        });
        
    });

    $('.xoaluotthuhocphi').on('click', function() {
        Swal.fire({
            title: 'Thao tác này sẽ xóa vĩnh viễn dữ liệu.Bạn có chắc chắn muốn xóa học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Đồng ý!',
            cancelButtonText: "Không đồng ý!"
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
                        }, 800);
                    }
                }
            });
        }
        });
    });
    $('.bosunghocsinh').on('click', function() {
        Swal.fire({
            title: 'Bạn có muốn bổ sung toàn bộ học sinh của lớp vào danh sách thu học phí tháng không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Đồng ý!',
            cancelButtonText: "Không đồng ý!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphi/bosunghocsinh',
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

    $('.capnhatdadonghochocphitoanlop').on('click', function() {
        Swal.fire({
            title: 'Bạn có muốn cập nhật học sinh cả lớp lớp đã đóng học phí không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Đồng ý!',
            cancelButtonText: "Không đồng ý!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphi/capnhatdadonghochocphitoanlop',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Cập nhật thành công!');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 800);
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
            confirmButtonText: 'Đồng ý!',
            cancelButtonText: "Không đồng ý!"
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
                        }, 800);
                    }
                }
            });
        }
        });
    });

    $('#capnhattienhocchungtoanlop').on('change', function() {
        var tongtien = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlyhocphi/capnhattienhocchungtoanlop',
            method: 'post',
            data: {
                id: id,
                tongtien: tongtien,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('Cập nhật thành công');
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>