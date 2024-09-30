<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <label>NHẬP SỐ BUỔI:</label>
                    <input type="number" name="SOBUOITINHTIEN" class="form-control" value="<?= $inputs ? $inputs['SOBUOITINHTIEN'] : null?>">
                </div>
                <div class="col-md-2">
                    <label>NHẬP TỔNG TIỀN HỌC:</label>
                    <input type="number" name="NHAPTONGTIEN" class="form-control" value="<?= $inputs ? $inputs['NHAPTONGTIEN'] : null?>">
                </div>
                <div class="col-md-2">
                    <label>NHẬP TIỀN SÁCH/ TÀI LIỆU:</label>
                    <input type="number" name="NHAPTIENSACH" class="form-control" value="<?= $inputs ? $inputs['NHAPTIENSACH'] : null?>">
                </div>
                <div class="col-md-2">
                    <label></label>
                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-updatedata-form']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS
    $(document).on('click', '#submit-updatedata-form', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Bạn có chắc chắn muốn thay đổi toàn bộ dữ liệu của lớp học không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'THAY ĐỔI!',
            cancelButtonText: "KHÔNG!"
        }).then((result) => {
        if (result['isConfirmed']) {
            $('#w1').submit();
        }
        });
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
JS;
$this->registerJs($script);
?>