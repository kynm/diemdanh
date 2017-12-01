<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Tramvt;
use app\models\Nhanvien;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dotbaoduong-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_DOTBD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NGAY_BD')->textInput() ?>

    <?= $form->field($model, 'ID_TRAMVT')->dropDownList(ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'));
    ?>

    <?= $form->field($model, 'TRUONG_NHOM')->dropDownList(ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'));
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
