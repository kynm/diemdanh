<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DonviSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donvi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DONVI') ?>

    <?= $form->field($model, 'MA_DONVI') ?>

    <?= $form->field($model, 'TEN_DONVI') ?>

    <?= $form->field($model, 'DIA_CHI') ?>

    <?= $form->field($model, 'SO_DT') ?>

    <?php // echo $form->field($model, 'CAP_TREN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
