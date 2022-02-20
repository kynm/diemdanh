<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
$dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
$dsDichvu = [
    1 => 'Fiber',
    2 => 'MyTV',
];
?>

<div class="donvi-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'donvi_id')->dropDownList($dsDonvi,['prompt' => 'Chọn đơn vị chủ quản']
                    ) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'dichvu_id')->dropDownList($dsDichvu,['prompt' => 'Chọn dịch vụ']
                    ) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'ten_kh')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-12">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'so_dt')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'noidung')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
            
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>
