<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Baoduongtong */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="baoduongtong-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_BDT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MO_TA')->textArea(['class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
