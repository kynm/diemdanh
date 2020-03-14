<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tramvt;
use app\models\Nhanvien;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */

$listtramvt = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM');
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-3">
                <?= $form->field($model, 'ID_NV_VANHANH')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                    'options' => ['placeholder' => 'Nhân viên vận hành'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'ID_TRAM')->widget(Select2::classname(), [
                    'data' => $listtramvt,
                    'options' => ['placeholder' => 'Chọn trạm'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'DINHMUC')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'GIATIEN')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'THOIGIANBATDAU')->textInput(['type' => 'datetime']) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'THOIGIANKETTHUC')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'GHICHU')->textInput(['maxlength' => true]) ?>
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
