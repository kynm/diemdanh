<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $chamdiem->TIEUDE;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
    <?= Html::a('<i class="fa fa-back"></i> QUAY LẠI', ['chamdiem/chamdiemlophoc', 'idlophoc' => $chamdiem->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
    <span class="btn btn-danger btn-flat pull-right" id="boxungchamdiemlophoc" data-chamdiemid="<?= $chamdiem->ID?>">Bổ Sung học sinh</span>
<?php endif; ?>
<?php if (Yii::$app->user->can('diemdanhlophoc') && $chamdiem->lop->STATUS == 1):?>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <?php $form = ActiveForm::begin(['action' =>['chamdiem/capnhatchamdiem', 'id' => $chamdiem->ID], 'method' => 'post']); ?>
            <div class="col-sm-12">
                    <?= $form->field($chamdiem, 'TIEUDE')->textInput(['maxlength' => true]) ?>
                </div>
            <div class="col-sm-12">
                <?= $form->field($chamdiem, 'NOIDUNG')->widget(Summernote::class, [
                    'options' => ['placeholder' => 'NỘI DUNG BÀI KIỂM TRA',
                    'data-id' => $chamdiem->ID,
                    'class' => 'noidungchamdiem',
                ]
                ]);
                ?>
            </div>
            <?php ActiveForm::end(); ?>
            <?php foreach ($chamdiem->dschitietchamdiem as $key => $chitiet):?>
                <div class="col-sm-6">
                    <div class="col-sm-3" style="font-size:20px">
                        <?= Html::a($chitiet->hocsinh->HO_TEN, ['/hocsinh/lichsuchamdiem', 'id' => $chitiet->hocsinh->ID], ['target' => '_blank']) ?>
                        <?php if (Yii::$app->user->identity->nhanvien->iDDONVI->SHOWALL):?>
                            <span class="xemtoanbothongtin">(<?= $chitiet->hocsinh->SO_DT . ' - ' . $chitiet->hocsinh->DIA_CHI?>)</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control capnhatdiem" type="number" step="0.01" data-id="<?= $chitiet->ID ?>" value="<?= $chitiet->DIEM?>" placeholder="ĐIỂM">
                    </div>
                    <div class="col-sm-6">
                        <textarea class="form-control capnhatghichu" data-id="<?= $chitiet->ID ?>" placeholder="NHẬN XÉT"><?= $chitiet->NHAN_XET?></textarea>
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
        $('#w0').submit();
    });
    $(document).on('blur', '#chamdiem-tieude', function () {
        $('#w0').submit();
    });

    $('.capnhatghichu').on('change', function() {
        var capnhatghichu = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/chamdiem/capnhatghichu',
            method: 'post',
            data: {
                id: id,
                capnhatghichu: capnhatghichu,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });

    $('.capnhatdiem').on('change', function() {
        var diem = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/chamdiem/capnhatdiem',
            method: 'post',
            data: {
                id: id,
                diem: diem,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });

    $('#boxungchamdiemlophoc').on('click', function() {
        var chamdiemid = $(this).data('chamdiemid');
        console.log(chamdiemid);
        $.ajax({
            url: '/chamdiem/boxungchamdiemlophoc',
            method: 'POST',
            data: {
                'chamdiemid' : chamdiemid,
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