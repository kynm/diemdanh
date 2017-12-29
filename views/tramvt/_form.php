<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_TRAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIADIEM')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'ID_DAIVT')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Daivt::find()->all(), 'ID_DAI', 'TEN_DAIVT'),
        'options' => ['placeholder' => 'Chọn đài quản lý'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'ID_NHANVIEN')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
        'options' => ['placeholder' => 'Chọn nhân viên quản lý'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
