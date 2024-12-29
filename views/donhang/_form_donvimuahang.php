<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="daivt-form">
    <div class="box box-primary">
        <div class="box-body">
            <div>
                <div class="row col-sm-12">
                    <img src="/dist/img/banggia.png" style="display: block;margin-left: auto;margin-right: auto;max-width: 90%;height: 500px;">
                </div>
            </div>
            <div class="row col-sm-12">
                <h3>GÓI HIỆN TẠI:</h3>
                <h4 class="text text-primary">SỐ HỌC SINH: <?= Yii::$app->user->identity->nhanvien->iDDONVI->SO_HS?></h4>
                <h4 class="text text-primary">NGÀY HẾT HẠN: <?= Yii::$app->formatter->asDatetime(Yii::$app->user->identity->nhanvien->iDDONVI->NGAY_KT, 'php:d/m/Y')?></h4>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'SO_HS')->textInput(['maxlength' => true, 'type' => 'number']) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'GHICHU')->textarea(['rows' => '6']) ?>
                </div>
            </div>
            <div class="box-footer col-sm-12">
                <div class="text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="box-footer col-sm-12">
                <div class="text-center">
                    <a href="#"> <a href="https://www.facebook.com/easycheckvn" target="_blank"><i class="fa fa-facebook" style="font-size: 36px;"></i> LIÊN HỆ HỖ TRỢ QUA FACEBOOK</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
