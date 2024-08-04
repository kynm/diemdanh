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
    <?php if (Yii::$app->user->can('quanlyhocphi') && !$model->getChitiethocphi()->where(['STATUS' => 1])->count()):?>
    <p>
        <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                'method' => 'post',
            ],
        ]) ?>
    <?= Html::a('<i class="fa fa-pencil-square-o"></i> In theo lớp', ['/quanlyhocphi/inhocphitheolop', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
    </p>
    <?php endif; ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_LOP',
                        'value' => $model->lop->TEN_LOP,
                    ],
                    'TIEUDE',
                    'TU_NGAY',
                    'DEN_NGAY',
                    'TIENHOC',
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="box-body table-responsive">
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
                <th class="text-center">TIỀN KHÁC</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet):
                ?>
                <tr>
                    <td scope="col"><?= $key + 1;?></td>
                    <td><?= $chitiet->hocsinh->HO_TEN?></td>
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
                        <?= Html::a('<i class="fa fa-pencil-square-o"></i> In học phí', ['/quanlyhocphi/chitiethocphi', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
                        <?php if (Yii::$app->user->can('quanlyhocphi') && !$chitiet->STATUS):?>
                            <span class="btn btn-flat btn-danger xacnhanthuhocphi" data-id="<?= $chitiet->ID ?>">Xác nhận thu tiền</span>
                        <?php else: ?>
                            <span class="btn btn-flat btn-success">Đã thu</span>
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