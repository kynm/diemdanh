<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Nguyennhan;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
$dsNguyennhan = ArrayHelper::map(Nguyennhan::find()->all(), 'id', 'nguyennhan');
$dsdanhgia = [
    1 => 'Rất không hài lòng',
    2 => 'Không hài lòng',
    3 => 'Bình thường',
    4 => 'Hài lòng',
    5 => 'Rất hài lòng',
];
$status = statusbaohong();
$listStatus = [0 => 'Mở lại yêu cầu', 4 => $status[4]];
if ($model->status == 1) {
    $listStatus = [0 => 'Mở lại yêu cầu', 5 => $status[5]];
    $model->status = 5;
} else {
    $model->status = 4;
}
?>
<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'status')->radioList($listStatus, ['separator'=>'<br/>'])->label('Xử lý yêu cầu'); ?> 
                </div>
                <div class="col-md-2">
                    <label class="text text-danger"></label>
                    <?= $form->field($model, 'danhgia')->radioList($dsdanhgia, ['separator'=>'<br/>']);?> 
                </div>
                <div class="col-md-6">
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
