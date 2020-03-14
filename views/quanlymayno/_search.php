<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramvtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramvt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_TRAM') ?>

    <?= $form->field($model, 'TEN_TRAM') ?>

    <?= $form->field($model, 'DIADIEM') ?>

    <?= $form->field($model, 'ID_DAI') ?>

    <?= $form->field($model, 'ID_NHANVIEN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
