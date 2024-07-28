<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
$model->TIEUDE = 'ĐIỂM DANH NGÀY ' . $model->NGAY_DIEMDANH;
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(['action' =>['lophoc/themdiemdanh', 'id' => $id], 'method' => 'post']); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label">Ngày điểm danh</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_DIEMDANH',
                        'name' => 'NGAY_DIEMDANH', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày điểm danh'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'TIEUDE')->textInput(['maxlength' => true]) ?>
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
<?php
$script = <<< JS
    $('#quanlydiemdanh-ngay_diemdanh').on('change', function() {
        var NGAYDIEMDANH = $(this).val();
        $('#quanlydiemdanh-tieude').val('ĐIỂM DANH NGÀY ' + NGAYDIEMDANH);
    });
JS;
$this->registerJs($script);
?>
