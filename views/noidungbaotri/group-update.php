<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Nhomtbi;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Cập nhật nội dung ' . $model->MA_NOIDUNG;

$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="noidungbaotri-update">

    <div class="box box-primary">
    
        <?php $form = ActiveForm::begin(); ?>
    
        <div class="box-body">
            <div class="col-sm-6">
                <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'ID_NHOM')->dropDownList(
                    ArrayHelper::map(Nhomtbi::find()->all(), 'ID_NHOM', 'TEN_NHOM')) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'NOIDUNG')->textArea(['cols' => 6]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'CHUKY')->textInput(['maxlength' => true, 'type' => 'number'])->label('Chu kỳ (tháng)') ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'QLTRAM')->dropDownList(
                    [
                        0 => 'Đội BDUCTT',
                        1 => 'Quản lý trạm'
                    ],
                    [
                        'prompt' => 'Chọn bộ phận thực hiện',
                    ])->label('Bộ phận thực hiện') ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'type')->dropDownList(
                    [
                        0 => 'Đạt / Không đạt',
                        1 => 'Nhập kết quả'
                    ],
                    [
                        'prompt' => 'Yêu cầu kết quả công việc',
                    ])->label('Yêu cầu kết quả công việc') ?>
            </div>
            <div class="col-sm-12" id="yeucaunhap" hidden>
                <?= $form->field($model, 'YEUCAUNHAP')->textArea(['placeholder' => 'Nhập điện áp/số dòng/thời gian xả...v.v...'])->label('Nội dung yêu cầu') ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>            
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
<?php
$script = <<< JS
    $( document ).ready(function() {
        typeChange();
        $('#noidungbaotrinhomtbi-type').change(function(){
            typeChange();
        })
    });
    function typeChange(){
        var type = $('#noidungbaotrinhomtbi-type').val();
        if(type == 0){
            $('#yeucaunhap').hide();
        }
        if(type == 1){
            $('#yeucaunhap').show();
        }
    }
JS;
$this->registerJs($script);
?>