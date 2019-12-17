<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduongNoidung */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-baoduong-noidung-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_PROFILE')->textInput() ?>

    <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
