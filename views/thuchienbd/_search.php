<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ThuchienbdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thuchienbd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DOTBD') ?>

    <?= $form->field($model, 'ID_THIETBI') ?>

    <?= $form->field($model, 'MA_NOIDUNG') ?>

    <?= $form->field($model, 'NOIDUNGMORONG') ?>

    <?= $form->field($model, 'KETQUA') ?>

    <?php // echo $form->field($model, 'GHICHU') ?>

    <?php // echo $form->field($model, 'ID_NHANVIEN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
