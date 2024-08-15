<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'TIEUDE')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'ID_LOP')->widget(Select2::classname(), [
                        'data' => $dslop,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn lớp',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'ID_HOCSINH')->widget(Select2::classname(), [
                        'data' => [],
                        'pluginOptions' => [
                            'placeholder' => 'Chọn học sinh',
                            'allowClear' => true,
                            'multiple' => true
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'SOTIEN')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'SO_BH')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'TIENKHAC')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">TỪ NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_BD',
                        'name' => 'NGAY_BD', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'TỪ NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">ĐẾN NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_KT',
                        'name' => 'NGAY_KT', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'ĐẾN NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'GHICHU')->textarea(['rows' => '6']) ?>
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
    $('#quanlyhocphithutruoc-id_lop').on('change', function() {
      var lopid = $(this).val();
        $.ajax({
            url: '/lophoc/listdshocsinhtheolop',
            method: 'POST',
            data: {
                'lopid' : lopid,
            },
            success:function(data) {
                $("#quanlyhocphithutruoc-id_hocsinh").html(data);
            }
        });
    });

    $('#quanlyhocphithutruoc-id_hocsinh').on('change', function() {
        $('#quanlyhocphithutruoc-sotien').val(null);
        $('#quanlyhocphithutruoc-so_bh').val(null);
    });
JS;
$this->registerJs($script);
?>