<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use kartik\date\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'MA_HOCSINH')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-3">
                    <?= $form->field($model, 'HO_TEN')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">Ngày sinh</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_SINH',
                        'name' => 'NGAY_SINH', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày sinh'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ID_LOP')->widget(Select2::classname(), [
                        'data' => $dslop,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhân viên điểm danh',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'TIENHOC')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'SO_DT')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($model, 'DIA_CHI')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label">Ngày BD</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_BD',
                        'name' => 'NGAY_BD', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày BD'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Ngày KT</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_KT',
                        'name' => 'NGAY_KT', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày KT'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-6">
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