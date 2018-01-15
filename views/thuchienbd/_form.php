<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thuchienbd-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-4">
                <?= $form->field($model, 'ID_DOTBD')->textInput(['value' => $model->iDDOTBD->MA_DOTBD, 'disabled' => true]) ?>
            </div>
            
            <div class="col-sm-4">
                <?= $form->field($model, 'ID_THIETBI')->textInput(['value' => $model->iDTHIETBI->iDLOAITB->TEN_THIETBI, 'disabled' => true]) ?>
            </div>
            
            <div class="col-sm-4">
                <?= $form->field($model, 'MA_NOIDUNG')->textInput(['value' => $model->mANOIDUNG->NOIDUNG, 'disabled' => true]) ?>
            </div>
            
            <div class="col-sm-4">
                <?= $form->field($model, 'KETQUA')->dropDownList([ 'Đạt' => 'Đạt', 'Chưa đạt' => 'Chưa đạt' ],['prompt'=>'Tự đánh giá kết quả' ]) ?>
            </div>
            
            <div class="col-sm-4">
                <?= $form->field($model, 'NOIDUNGMORONG')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-sm-4">
                <?= $form->field($model, 'GHICHU')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'ID_NHANVIEN')->textInput(['maxlength' => true]) ?>
            </div>            
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>            
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
