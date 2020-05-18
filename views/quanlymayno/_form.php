<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tramvt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */

$listtramvt = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM');
$listloaisuco = [
    1 => 'Mất điện',
    2 => 'Bảo dưỡng thiết bị',
];
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_THIETBITRAM')->hiddenInput(['value'=> $thietbitram->ID_THIETBI])->label(false);?>
    <?= $form->field($model, 'USER_ID')->hiddenInput(['value'=> Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->label(false);?>
    <?= $form->field($model, 'DINHMUC')->hiddenInput(['value'=> json_decode($thietbitram->THAMSOTHIETBI)->DINH_MUC])->label(false);?>
    <?= $form->field($model, 'LOAINHIENLIEU')->hiddenInput(['value'=> json_decode($thietbitram->THAMSOTHIETBI)->LOAINHIENLIEU])->label(false);?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-3">
                <?= $form->field($model, 'ID_NV_DIEUHANH')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Nhanvien::find()->where(['ID_DONVI' => 666])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                    'options' => ['placeholder' => 'Nhân viên điều hành'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'ID_NV_VANHANH')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Nhanvien::find()->where(['ID_DAI' => $thietbitram->iDTRAM->ID_DAI])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
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
                <?= $form->field($model, 'LOAI_SU_CO')->widget(Select2::classname(), [
                    'data' => $listloaisuco,
                    'options' => ['placeholder' => 'Chọn loại sự cố'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'THOIGIANBATDAU')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Dự kiến bắt đầu'],
                    'pluginOptions' => [
                        'autoclose' => true
                        ]
                    ]);
                ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'THOIGIANKETTHUC')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Dự kiến bắt đầu'],
                    'pluginOptions' => [
                        'autoclose' => true
                        ]
                    ]);
                ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'GHICHU')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'IS_CHECKED')->checkBox(['label' => 'Xác nhận']) ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
                <a class="btn btn-success btn-flat" style="float: right;" href="<?= Url::to(['quanlymayno/'])?>">Về trang quản máy nổ</a>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
