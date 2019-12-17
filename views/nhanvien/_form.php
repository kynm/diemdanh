<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Daivt;
use app\models\Chucvu;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nhanvien-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'MA_NHANVIEN')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-4">
                    <?= $form->field($model, 'TEN_NHANVIEN')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-4">
                    <?= $form->field($model, 'CHUC_VU')->dropDownList(ArrayHelper::map(Chucvu::find()->all(), 'id', 'ten_chucvu'), ['prompt' => 'Chọn chức vụ' ]); ?>
                </div>
            </div>
                
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'DIEN_THOAI')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-4">
                    <?= $form->field($model, 'ID_DONVI')->dropDownList(ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'), 
                        [
                            'prompt' => "Chọn đơn vị",
                            'onchange' => '
                                $.post("'.Yii::$app->homeUrl.'nhanvien/list?id="+$(this).val(), function( data ) {
                                    $("#nhanvien-id_dai").html( data );
                                });'
                        ]); ?>
                </div>
                    
                <div class="col-sm-4">
                    <?= $form->field($model, 'ID_DAI')->dropDownList(ArrayHelper::map(Daivt::find()->all(), 'ID_DAI', 'TEN_DAIVT'), ['prompt' => 'Chọn đài viễn thông' ]); ?> 
                </div>
            </div>
                
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'USER_NAME')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord ? false : true ]) ?>
                </div>

                <div class="col-sm-4">
                    <?php if (!$model->isNewRecord) {
                        echo $form->field($model->user, 'password')->passwordInput(['maxlength' => true]);
                    }  ?>
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
