<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $diemdanh->TIEUDE;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail_diemdanh', [
        'model' => $diemdanh,
    ]) ?>
</div>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <?php foreach ($diemdanh->dschitietdiemdanh as $key => $chitiet):?>
                <div class="col-sm-6">
                    <div class="col-sm-3" style="font-size:20px">
                        <input type="checkbox" name="" <?= $chitiet->STATUS ? "checked" : null?> class="chuyendoitrangthaidiemdanh" data-diemdanhhsid="<?= $chitiet->ID?>" style="height: 25px;width: 25px;"> <?= $chitiet->hocsinh->HO_TEN?>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control capnhatghichu" data-id="<?= $chitiet->ID ?>" placeholder="GHI CHÚ"><?= $chitiet->NHAN_XET?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $('.chuyendoitrangthaidiemdanh').on('change', function() {
        var diemdanhhsid = $(this).data('diemdanhhsid');
        var status = $(this).is(":checked") ? 1 : 0;
        $.ajax({
            url: '/lophoc/capnhattrangthaidiemdanh/?diemdanhhsid=' + diemdanhhsid ,
            method: 'POST',
            data: {
                'STATUS' : status,
            },
            success:function(data) {
                if (!data.error) {
                    Swal.fire('ĐÃ CẬP NHẬT!','success');
                }
            }
        });
    });

    $('.capnhatghichu').on('change', function() {
        var capnhatghichu = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlydiemdanh/capnhatghichu',
            method: 'post',
            data: {
                id: id,
                capnhatghichu: capnhatghichu,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>