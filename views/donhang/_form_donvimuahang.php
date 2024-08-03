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
            <div class="row col-sm-6">
                <div class="row col-sm-12">
                    <img src="/dist/img/banggia.png" style="display: block;margin-left: auto;margin-right: auto;width: 90%;">
                </div>
                <div class="row col-sm-12">
                    <img src="/dist/img/qrcode.jpg" style="display: block;margin-left: auto;margin-right: auto;width: 50%;">
                </div>
            </div>
            <div class="row col-sm-6">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SOTIEN')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'GHICHU')->textarea(['rows' => '6']) ?>
                </div>
            </div>
            <div class="box-footer">
                <div class="text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
