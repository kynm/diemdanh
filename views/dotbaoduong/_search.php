<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DotbaoduongSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dotbaoduong-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DOTBD') ?>

    <?= $form->field($model, 'MA_DOTBD') ?>

    <?= $form->field($model, 'NGAY_BD') ?>

    <?= $form->field($model, 'ID_TRAMVT') ?>

    <?= $form->field($model, 'TRUONG_NHOM') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
