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
                <div class="col-sm-4">
                    <input type="checkbox" name="" <?= $chitiet->STATUS ? "checked" : null?> class="chuyendoitrangthaidiemdanh" data-diemdanhhsid="<?= $chitiet->ID?>"> <?= $chitiet->hocsinh->HO_TEN?>
                    <br/>
                    <br/>
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
JS;
$this->registerJs($script);
?>