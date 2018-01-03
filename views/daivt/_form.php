<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_DAIVT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEN_DAIVT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIA_CHI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SO_DT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_DONVI')->dropDownList(
        ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'),
        ['prompt' => 'Chọn đơn vị chủ quản']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
