<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
$dsTrangthai = [
    0 => 'Chờ tiếp nhận',
    1 => 'Báo sai',
    2 => 'Đang xử lý',
    3 => 'Đã xử lý',
];
?>
<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'status')->dropDownList($dsTrangthai,['prompt' => 'Chọn trạng thái xử lý']
                    ) ?>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'ghichu')->textarea(['rows' => '6']) ?>
                </div>
            </div>
        </div>
            
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>
