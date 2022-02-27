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
$status = statusbaohong();
unset($status[0]);
unset($status[4]);
unset($status[5]);
?>
<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'nhanvien_xl_id')->widget(Select2::classname(), [
                        'data' => $dsNhanvien,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhân viên',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'data' => $status,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn trạng thái xử lý',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'nguyennhan_id')->widget(Select2::classname(), [
                        'data' => $dsNguyennhan,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nguyên nhân',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ghichu')->textarea(['rows' => '6']) ?>
                </div>
            </div>
        </div>
            
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
