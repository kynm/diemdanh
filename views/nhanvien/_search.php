<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NhanvienSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nhanvien-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_NHANVIEN') ?>

    <?= $form->field($model, 'MA_NHANVIEN') ?>

    <?= $form->field($model, 'TEN_NHANVIEN') ?>

    <?= $form->field($model, 'CHUC_VU') ?>

    <?= $form->field($model, 'DIEN_THOAI') ?>

    <?php // echo $form->field($model, 'ID_DONVI') ?>

    <?php // echo $form->field($model, 'ID_DAI') ?>

    <?php // echo $form->field($model, 'GHI_CHU') ?>

    <?php // echo $form->field($model, 'USER_NAME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
