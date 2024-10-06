<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'TIEUDE')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ID_LOP')->widget(Select2::classname(), [
                        'data' => $dslop,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn lớp',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'TIENHOC', ['options' => ['data-lopid' => $model->ID_LOP]])->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'SO_BH')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">TỪ NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'TU_NGAY',
                        'name' => 'TU_NGAY', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'TỪ NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">ĐẾN NGÀY</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'DEN_NGAY',
                        'name' => 'DEN_NGAY', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'ĐẾN NGÀY'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS
    $('#quanlyhocphi-tieude').focus();

JS;
$this->registerJs($script);
?>
