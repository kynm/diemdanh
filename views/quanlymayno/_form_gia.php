<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tramvt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $months[date('m', strtotime("+$i month"))] = date('m', strtotime("+$i month"));
            }
            $nowY = date("Y");
            $years = [
                $nowY => $nowY,
                $nowY - 1 => $nowY - 1,
            ];
            $loainhienlieu = [
                1 => 'Diel',
                2 => 'Xăng',
            ]
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-3">
                <?= $form->field($model, 'LOAI_NHIENLIEU')->widget(Select2::classname(), [
                    'data' => $loainhienlieu,
                    'options' => ['placeholder' => 'Loại nhiên liệu'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'THANG')->widget(Select2::classname(), [
                    'data' => $months,
                    'options' => ['placeholder' => 'Tháng'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'NAM')->widget(Select2::classname(), [
                    'data' => $years,
                    'options' => ['placeholder' => 'Năm'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'DONGIA')->textInput(['maxlength' => true]) ?>
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
