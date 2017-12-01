<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ThietbiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_THIETBI') ?>

    <?= $form->field($model, 'MA_THIETBI') ?>

    <?= $form->field($model, 'TEN_THIETBI') ?>

    <?= $form->field($model, 'ID_NHOMTB') ?>

    <?= $form->field($model, 'HANGSX') ?>

    <?php // echo $form->field($model, 'NGAYSX') ?>

    <?php // echo $form->field($model, 'SERIAL_MAC') ?>

    <?php // echo $form->field($model, 'NGAYSUDUNG') ?>

    <?php // echo $form->field($model, 'THONGSOKT') ?>

    <?php // echo $form->field($model, 'PHUKIEN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
