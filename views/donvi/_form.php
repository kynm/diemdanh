<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'MA_DONVI')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'TEN_DONVI')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-4">
                    <?= $form->field($model, 'DIA_CHI')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'SO_DT')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'SHOWALL')->checkBox(['label' => 'HIỂN THỊ TOÀN BỘ THÔNG TIN HỌC VIÊN KHI ĐIỂM DANH']) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'DIEMDANHTHUCONG')->checkBox(['label' => 'ĐIỂM DANH THỦ CÔNG (KHÔNG TỰ ĐỘNG TẠO ĐIỂM DANH CHO CẢ LỚP, THỰC HIỆN ĐIỂM DANH HỌC SINH NÀO THÌ GHI NHẬN HỌC SINH ĐÓ)']) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'HPTT')->checkBox(['label' => 'HỌC PHÍ THEO THÁNG)']) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'HP_T')->checkBox(['label' => 'HỌC PHÍ THU TRƯỚC']) ?>
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
