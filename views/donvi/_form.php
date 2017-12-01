<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donvi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_DONVI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEN_DONVI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIA_CHI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SO_DT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAP_TREN')->dropDownList(
        ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'),
        ['prompt' => 'Chọn đơn vị cấp trên']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
