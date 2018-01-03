<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nhomtbi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_NHOM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEN_NHOM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
