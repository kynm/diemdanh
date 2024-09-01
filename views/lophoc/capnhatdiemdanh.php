<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;

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
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
    <?= Html::a('<i class="fa fa-back"></i> QUAY LẠI', ['lophoc/quanlydiemdanh', 'id' => $diemdanh->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
    <span class="btn btn-danger btn-flat pull-right" id="boxungdiemdanhlophoc" data-diemdanhid="<?= $diemdanh->ID?>">Bổ Sung học sinh</span>
<?php endif; ?>
<?php if (Yii::$app->user->can('diemdanhlophoc') && $diemdanh->lop->STATUS == 1):?>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <?php if($diemdanh->NOIDUNG) :?>
            <?php $form = ActiveForm::begin(['action' =>['quanlydiemdanh/capnhatghichubuoihoc', 'id' => $diemdanh->ID], 'method' => 'post']); ?>
            <div class="col-sm-12">
                <?= $form->field($diemdanh, 'NOIDUNG')->widget(Summernote::class, [
                    'options' => ['placeholder' => 'NỘI DUNG BUỔI HỌC',
                    'data-id' => $diemdanh->ID,
                    'class' => 'noidungbuoihoc',
                ]
                ]);
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php endif;?>
            <?php foreach ($diemdanh->dschitietdiemdanh as $key => $chitiet):?>
                <div class="col-sm-6">
                    <div class="col-sm-3" style="font-size:20px">
                        <input type="checkbox" name="" <?= $chitiet->STATUS ? "checked" : null?> class="chuyendoitrangthaidiemdanh" data-diemdanhhsid="<?= $chitiet->ID?>" style="height: 25px;width: 25px;">
                        <?= Html::a($chitiet->hocsinh->HO_TEN, ['/hocsinh/lichsudiemdanh', 'id' => $chitiet->hocsinh->ID], ['target' => '_blank']) ?>
                        <?php if (Yii::$app->user->identity->nhanvien->iDDONVI->SHOWALL):?>
                            <span class="xemtoanbothongtin">(<?= $chitiet->hocsinh->SO_DT . ' - ' . $chitiet->hocsinh->DIA_CHI?>)</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control capnhatghichu" data-id="<?= $chitiet->ID ?>" placeholder="GHI CHÚ"><?= $chitiet->NHAN_XET?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php
$script = <<< JS
    $(document).on('blur', '.note-editable', function () {
        $('#w1').submit();
        // var capnhatghichu = $(this).val();
        // var id = $(this).data('id');
        // $.ajax({
        //     url: '/quanlydiemdanh/capnhatghichubuoihoc',
        //     method: 'post',
        //     data: {
        //         id: id,
        //         capnhatghichu: capnhatghichu,
        //     },
        //     success:function(data) {
        //         data = jQuery.parseJSON(data);
        //         if (!data.error) {
        //             Swal.fire(data.message);
        //         }
        //     }
        // });
    });
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

    $('#boxungdiemdanhlophoc').on('click', function() {
        var diemdanhid = $(this).data('diemdanhid');
        console.log(diemdanhid);
        $.ajax({
            url: '/lophoc/boxungdiemdanhlophoc',
            method: 'POST',
            data: {
                'diemdanhid' : diemdanhid,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire(data.message,'success');
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    Swal.fire(data.message,'success');

                }
            }
        });
    });
JS;
$this->registerJs($script);
?>