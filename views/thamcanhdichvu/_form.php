<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donvi-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <?php if(Yii::$app->user->can('Administrator')): ?>
                <div class="col-md-2">
                    <?= $form->field($model, 'nhanvien_id')->widget(Select2::classname(), [
                        'data' => $dsNhanvien,
                        'pluginOptions' => [
                            'placeholder' => 'Nhân viên',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <?= $form->field($model, 'TEN_KH')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-4">
                    <?= $form->field($model, 'MST')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'LIENHE')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-1">
                    <br/>
                    <a href="tel:<?= $model->LIENHE?>"><i class="fa fa-phone"></i>Liên hệ</a>
                </div>  
                <div class="col-md-12">
                    <?= $form->field($model, 'DIACHI')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'ghichu')->textarea(['rows' => '6']) ?>
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
