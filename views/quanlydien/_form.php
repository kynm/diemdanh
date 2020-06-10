<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qldien-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'MA_DIENLUC')->hiddenInput()->label(false);?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-6">
                <?= $form->field($model, 'DINHMUC')->textInput(['maxlength' => true]) ?>
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
