<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Dichvu;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
$dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
$dsDichvu = ArrayHelper::map(Dichvu::find()->all(), 'id', 'ten_dv');
?>
<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'donvi_id')->dropDownList($dsDonvi, 
                        [
                            'prompt' => "Chọn đơn vị",
                            'onchange' => '
                                $.post("'.Yii::$app->homeUrl.'nhanvien/listnvdonvi?id="+$(this).val(), function( data ) {
                                    $("#baohong-nhanvien_xl_id").html( data );
                                });'
                        ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'dichvu_id')->widget(Select2::classname(), [
                        'data' => $dsDichvu,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn dịch vụ',
                            'allowClear' => true,
                            'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'nhanvien_xl_id')->widget(Select2::classname(), [
                        'data' => $dsNhanvien,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhân viên',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ten_kh')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ma_tb')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-12">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'so_dt')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'noidung')->textInput(['maxlength' => true]) ?>
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
