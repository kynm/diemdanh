<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ThietbitramSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbitram-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_THIETBI') ?>

    <?= $form->field($model, 'ID_LOAITB') ?>

    <?= $form->field($model, 'ID_TRAM') ?>

    <?= $form->field($model, 'SERIAL_MAC') ?>

    <?= $form->field($model, 'NGAYSX') ?>

    <?php // echo $form->field($model, 'NGAYSD') ?>

    <?php // echo $form->field($model, 'LANBD') ?>

    <?php // echo $form->field($model, 'LANBAODUONGTRUOC') ?>

    <?php // echo $form->field($model, 'LANBAODUONGTIEP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
