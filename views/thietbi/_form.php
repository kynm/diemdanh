<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Nhomtbi;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_THIETBI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEN_THIETBI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_NHOMTB')->dropDownList(
        ArrayHelper::map(Nhomtbi::find()->all(), 'ID_NHOM', 'TEN_NHOM'),
        ['prompt' => 'Chọn nhóm thiết bị']
    ) ?>

    <?= $form->field($model, 'HANGSX')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'THONGSOKT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PHUKIEN')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
