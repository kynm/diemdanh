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
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th style="width: 10px">#</th>
                <th >HỌC SINH</th>
                <th >TỔNG SỐ <br/>BUỔI</th>
                <th >SỐ BUỔI <br/>NGHỈ</th>
                <th >NGÀY NGHỈ</th>
                <th >SỐ BUỔI <br/>ĐI HỌC</th>
                <th >NGÀY ĐI HỌC</th>
                <th >SỐ BUỔI <br/>TÍNH TIỀN</th>
                <th >SỐ TIỀN <br/>MỖI BUỔI</th>
                <th >TIỀN HỌC</th>
                <th >GHI CHÚ</th>
                <th ></th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet): ?>
                <tr>
                    <td scope="col"><?= $key + 1;?></td>
                    <td><?= $chitiet->hocsinh->HO_TEN?></td>
                    <td><?= $chitiet->SO_BH?></td>
                    <td><?= $chitiet->SO_BN?></td>
                    <td><?= $chitiet->NGAY_NGHI?></td>
                    <td><?= $chitiet->SO_BDH?></td>
                    <td><?= $chitiet->NGAYDIHOC?></td>
                    <td><input class="form-control capnhatsotienmoibuoi" type="number" value="<?= $chitiet->TIENHOC?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhatsobuoitinhtien" type="number" value="<?= $chitiet->SO_BTT?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><input class="form-control capnhattongtien" id="tongtien-<?= $chitiet->ID ?>" type="number" value="<?= $chitiet->TONG_TIEN?>" data-id="<?= $chitiet->ID ?>"></td>
                    <td><textarea class="form-control capnhatghichu" data-id="<?= $chitiet->ID ?>"><?= $chitiet->NHAN_XET?></textarea></td>
                    <td><?= Html::a('<i class="fa fa-pencil-square-o"></i> Chi tiết học phí', ['/quanlyhocphi/chitiethocphi', 'id' => $chitiet->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?></td>
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
JS;
$this->registerJs($script);
?>