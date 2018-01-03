<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Tramvt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dotbaoduong-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MA_DOTBD')->textInput(['maxlength' => true]) ?>

    <label class="control-label">Ngày bảo dưỡng</label>
    <?= DatePicker::widget([
        'model' => $model,
        'attribute' => 'NGAY_BD',
        'name' => 'ngaybd', 
        'removeButton' => false,
        'options' => ['placeholder' => 'Ngày bảo dưỡng ...'],
        'pluginOptions' => [

            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]); ?>

    <?= $form->field($model, 'ID_TRAMVT')->dropDownList(ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'));
    ?>

    <?= $form->field($model, 'TRUONG_NHOM')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
        'options' => ['placeholder' => 'Chọn nhóm trưởng'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
