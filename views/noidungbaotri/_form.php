<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noidungbaotri-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_THIETBI')->dropDownList(
        ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
        ['prompt' => 'Chọn nhóm thiết bị']
    ) ?>

    <?= $form->field($model, 'NOIDUNG')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
