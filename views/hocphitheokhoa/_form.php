<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'TIEUDE')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'ID_LOP')->widget(Select2::classname(), [
                        'data' => $dslop,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn lớp',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'TIENHOC', ['options' => ['data-lopid' => $model->ID_LOP]])->textInput(['maxlength' => true, 'type' => 'number']) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'SO_BH')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="control-label">TỪ NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'TU_NGAY',
                        'name' => 'TU_NGAY', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'TỪ NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <label class="control-label">ĐẾN NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'DEN_NGAY',
                        'name' => 'DEN_NGAY', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'ĐẾN NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
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
    $('#hocphitheokhoa-tieude').focus();
    $('#hocphitheokhoa-so_bh, #hocphitheokhoa-tu_ngay, #hocphitheokhoa-id_lop').on('change', function() {
        layngayketthuc();
    });

    $('#hocphitheokhoa-tu_ngay, #hocphitheokhoa-den_ngay').on('change', function() {
        tinhsobuoihoc();
    });

    function layngayketthuc() {
        var sobh = $('#hocphitheokhoa-so_bh').val();
        var tu_ngay = $('#hocphitheokhoa-tu_ngay').val();
        var lopid = $('#hocphitheokhoa-id_lop').val();
        if (sobh && tu_ngay && lopid) {
           $.ajax({
                url: '/quanlyhocphithutruoc/tinhngayketthuc',
                method: 'post',
                data: {
                    'lopid' : lopid,
                    'sobh' : sobh,
                    'ngay_bd' : tu_ngay,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        $("#hocphitheokhoa-den_ngay").val(data.NGAY_KT);
                    } else {
                        Swal.fire(data.message);
                    }
                }
            }); 
        }
    }
    function tinhsobuoihoc() {
        var tu_ngay = $('#hocphitheokhoa-tu_ngay').val();
        var den_ngay = $('#hocphitheokhoa-den_ngay').val();
        var lopid = $('#hocphitheokhoa-id_lop').val();
        if (tu_ngay && den_ngay && lopid) {
           $.ajax({
                url: '/quanlyhocphithutruoc/tinhsobuoihoc',
                method: 'post',
                data: {
                    'lopid' : lopid,
                    'tu_ngay' : tu_ngay,
                    'den_ngay' : den_ngay,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        $("#hocphitheokhoa-so_bh").val(data.SO_BH);
                        $("#hocphitheokhoa-tienhoc").val(data.TIENHOC);
                    } else {
                        Swal.fire(data.message);
                    }
                }
            }); 
        }
    }
JS;
$this->registerJs($script);
?>
