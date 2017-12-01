<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;
use app\models\Tramvt;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbitram-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_LOAITB')->dropDownList(
        ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
        ['prompt' => 'Chọn loại thiết bị']
    ) ?>

    <?= $form->field($model, 'ID_TRAM')->dropDownList(
        ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'),
        ['prompt' => 'Chọn trạm']
    ) ?>

    <?= $form->field($model, 'SERIAL_MAC')->textInput() ?>

    <?= $form->field($model, 'NGAYSX')->textInput() ?>
    
    <?= $form->field($model, 'NGAYSD')->textInput() ?>

    <?= $form->field($model, 'LANBD')->textInput() ?>

    <?= $form->field($model, 'LANBAODUONGTRUOC')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
