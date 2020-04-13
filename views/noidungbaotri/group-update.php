<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Nhomtbi;
use kartik\select2\Select2;
use app\models\Noidungbaotrinhomtbi;

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
            <div class="col-md-3">
                <?= $form->field($model, 'CHUKY')->textInput(['maxlength' => true, 'type' => 'number'])->label('Chu kỳ (tháng)') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'IMAGES')->dropDownList(
                                [
                                    0 => 'Không',
                                    1 => 'Có'
                                ]) ?>         
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'IS_PARENT')->dropDownList(
                    [
                        0 => 'Không',
                        1 => 'Có'
                    ])->label('Nội dung này có phân cấp?');
                ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'ID_PARENT')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Noidungbaotrinhomtbi::find()->where(['IS_PARENT' => 1])->all(), 'MA_NOIDUNG', 'NOIDUNG'),
                    'options' => ['placeholder' => 'Chọn nội dung cấp trên'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
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
                        'dat,khong_dat' => 'Đạt / Không đạt',
                        'tot,kem' => 'Tốt/ Kém',
                    ],
                    [
                        'value' => $model->arrayResult['KETQUABAODUONG']['value']
                    ])->label('Yêu cầu kết quả công việc') ?>
            </div>
            <div class="col-sm-12" id="yeucaunhap" hidden>
                <?= $form->field($model, 'YEUCAUNHAP')->textArea(['placeholder' => 'Nhập điện áp/số dòng/thời gian xả...v.v...'])->label('Nội dung yêu cầu') ?>
            </div>
            <div class="col-sm-12">
                <?php foreach($model->solieuthucte as $key => $sl) :?>
                    <div class="form-group">
                        <label>Thông số cần nhập: </label>
                        <input type="input" name="SOLIEUTHUCTE[][label]" value="<?php echo $sl['label']?>">
                    </div>
                <?php endforeach; ?>
                <?php for($i = 0; $i < 4 - count($model->solieuthucte); $i ++) :?>
                    <div class="form-group">
                        <label>Thông số cần nhập: </label><input type="input" name="SOLIEUTHUCTE[][label]" value="">
                    </div>
                <?php endfor;?>
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