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

$listtramvt = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM');
?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_THIETBITRAM')->hiddenInput(['value'=> $thietbitram->ID_THIETBI])->label(false);?>
    <?= $form->field($model, 'ID_NV_DIEUHANH')->hiddenInput(['value'=> Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->label(false);?>
    <?= $form->field($model, 'DINHMUC')->hiddenInput(['value'=> json_decode($thietbitram->THAMSOTHIETBI)->DINH_MUC])->label(false);?>
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
                <div class="form-group field-DINH_MUC required">
                    <label class="control-label" for="thietbitram-serial_mac">ĐỊNH MỨC</label>
                    <input type="text" class="form-control" name="" disabled="" value="<?php echo json_decode($thietbitram->THAMSOTHIETBI)->DINH_MUC;?>">
                    <div class="help-block"></div>
                </div>
                
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
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
