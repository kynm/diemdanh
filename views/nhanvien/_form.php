<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nhanvien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_NHANVIEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEN_NHANVIEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CHUC_VU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIEN_THOAI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_DONVI')->textInput() ?>

    <?= $form->field($model, 'ID_DAI')->textInput() ?>

    <?= $form->field($model, 'GHI_CHU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
