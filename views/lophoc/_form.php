<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Nhanvien;
use kartik\select2\Select2;
use kartik\editors\Summernote;
$dsnhanvien = ArrayHelper::map(Nhanvien::find()->where(['ID_DONVI' => $model->ID_DONVI])->andWhere(['!=', 'ID_NHANVIEN', Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN');
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daivt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'TEN_LOP')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'ID_NHANVIEN_DIEMDANH')->widget(Select2::classname(), [
                        'data' => $dsnhanvien,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhân viên điểm danh',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'TIENHOC')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'TEMP_NHANXET')->widget(Summernote::class, [
                            'options' => ['placeholder' => 'MẪU NHẬN XÉT LỚP HỌC CỦA GIÁO VIÊN']
                        ]) ?>
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
