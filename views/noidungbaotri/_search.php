<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NoidungbaotriSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noidungbaotri-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MA_NOIDUNG') ?>

    <?= $form->field($model, 'ID_THIETBI') ?>

    <?= $form->field($model, 'NOIDUNG') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
