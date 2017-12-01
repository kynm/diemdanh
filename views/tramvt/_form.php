<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_TRAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIADIEM')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'ID_DAIVT')->dropDownList(
        ArrayHelper::map(Daivt::find()->all(), 'ID_DAI', 'TEN_DAIVT'),
        ['promt' => 'Chọn đài quản lý']
    ) ?>

    <?= $form->field($model, 'ID_NHANVIEN')->dropDownList(
        ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
        ['promt' => 'Chọn nhân viên quản lý']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
