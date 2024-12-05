<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'ID_DONVI')->widget(Select2::classname(), [
                        'data' => $dsdonvi,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn ĐƠN VỊ',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
                        'data' => statusdonhang(),
                        'pluginOptions' => [
                            'placeholder' => 'CHỌN TRẠNG THÁI',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'TYPE')->widget(Select2::classname(), [
                        'data' => loaidonhang(),
                        'pluginOptions' => [
                            'placeholder' => 'CHỌN LOẠI ĐƠN HÀNG',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'SOTIEN')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'SO_LOP')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'SO_HS')->textInput(['maxlength' => true, 'type' => 'number']) ?>
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
