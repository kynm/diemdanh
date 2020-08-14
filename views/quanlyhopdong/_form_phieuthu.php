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
    <?= $form->field($model, 'ID_HOPDONG')->hiddenInput()->label(false);?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-12">
                <?= $form->field($model, 'ID_HOPDONG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <label class="control-label">Từ ngày</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'TUNGAY',
                        'name' => 'TUNGAY', 
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
                <label class="control-label">Đến ngày</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'DENNGAY',
                        'name' => 'DENNGAY', 
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
                <?= $form->field($model, 'SOTHANG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'GIATIEN')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'VAT')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'TONGTIEN')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'LOAI_CHUNGTU')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'TEN_NGUOINHAN')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'SOTAIKHOAN')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'TEN_NGANHANG')->textInput(['maxlength' => true]) ?>
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
