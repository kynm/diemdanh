<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KetquaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ketqua-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DOTBD') ?>

    <?= $form->field($model, 'ID_THIETBI') ?>

    <?= $form->field($model, 'KETQUA') ?>

    <?= $form->field($model, 'GHICHU') ?>

    <?= $form->field($model, 'ID_NHANVIEN') ?>

    <?php // echo $form->field($model, 'ANH1') ?>

    <?php // echo $form->field($model, 'ANH2') ?>

    <?php // echo $form->field($model, 'ANH3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
