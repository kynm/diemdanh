<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Dotbaoduong;
use app\models\Nhanvien;
use app\models\Noidungbaotri;
use app\models\Thietbitram;
use kartik\builder\Form;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungcongviec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noidungcongviec-form">

    <?php 
        $form = ActiveForm::begin();
    ?>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'ID_DOTBD')->dropDownList(
                        ArrayHelper::map(Dotbaoduong::find()->where(['TRANGTHAI' => 'Kế hoạch'])->all(), 'ID_DOTBD', 'MA_DOTBD'),
                        [
                            'prompt' => 'Chọn đợt bảo dưỡng',
                            'onchange' => '
                                $.post("/vnpt_mds/web/thietbitram/lists&id='.'"+$(this).val(), function( data ) {
                                    $("#noidungcongviec-id_thietbi").html( data );
                                });'
                        ])
                    ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ID_NHANVIEN')->dropDownList(
                        ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                        [
                            'prompt' => 'Chọn nhân viên bảo dưỡng',
                        ])
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'ID_THIETBI')->dropDownList(
                        ArrayHelper::map(Thietbitram::find()->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
                        [
                            'prompt' => 'Chọn thiết bị',
                            'onchange' => '
                                $.post("'. Url::to(['noidungbaotri/liststbt', 'id' => '$(this).val()']).', function( data ) {
                                    $("#noidungcongviec-ma_noidung").html( data );
                                });
                            '
                        ])
                    ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'MA_NOIDUNG')->dropDownList(
                        ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG'),
                        [
                            'prompt' => 'Chọn nội dung bảo dưỡng',
                        ])
                    ?>
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
