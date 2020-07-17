<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qldien-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'MA_CSHT')->hiddenInput()->label(false);?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-12">
                <?= $form->field($model, 'MA_HOPDONG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'TEN_HOPDONG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <label class="control-label">Ngày ký</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAYKY',
                        'name' => 'ngaybd', 
                        'removeButton' => false,
                        'options' => ['required' => true],
                        'pluginOptions' => [
                            'placeholder' => 'Dự kiến ...', 
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
            </div>
            <div class="col-sm-4">
                <label class="control-label">Ngày bắt đầu</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_BD',
                        'name' => 'ngaybd', 
                        'removeButton' => false,
                        'options' => ['required' => true],
                        'pluginOptions' => [
                            'placeholder' => 'Dự kiến ...', 
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
            </div>
            <div class="col-sm-4">
                <label class="control-label">Ngày kết thúc</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAYKT',
                        'name' => 'ngaybd', 
                        'removeButton' => false,
                        'options' => ['required' => true],
                        'pluginOptions' => [
                            'placeholder' => 'Dự kiến ...', 
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'TEN_VT')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'NGUOIDAIDIEN_A')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'NGUOIDAIDIEN_B')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'DIACHI')->textInput(['maxlength' => true]) ?>
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
