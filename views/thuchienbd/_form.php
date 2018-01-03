<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thuchienbd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_DOTBD')->textInput() ?>

    <?= $form->field($model, 'ID_THIETBI')->textInput() ?>

    <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOIDUNGMORONG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KETQUA')->textInput() ?>

    <?= $form->field($model, 'GHICHU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_NHANVIEN')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
