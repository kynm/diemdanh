<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduong */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-baoduong-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TEN_PROFILE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
