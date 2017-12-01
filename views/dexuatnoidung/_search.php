<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DexuatnoidungSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dexuatnoidung-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_LOAITB') ?>

    <?= $form->field($model, 'LAN_BD') ?>

    <?= $form->field($model, 'CHUKYBAODUONG') ?>

    <?= $form->field($model, 'MA_NOIDUNG') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
