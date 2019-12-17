<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BaoduongtongSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="baoduongtong-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'ID_BDT') ?>

    <?= $form->field($model, 'MA_BDT') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'MO_TA') ?>

    <?= $form->field($model, 'TRANGTHAI') ?>

    <?php // echo $form->field($model, 'ID_NHANVIEN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
