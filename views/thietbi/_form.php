<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Nhomtbi;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbi-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-3">                
                <?= $form->field($model, 'MA_THIETBI')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">                
                <?= $form->field($model, 'TEN_THIETBI')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">                
                <?= $form->field($model, 'ID_NHOMTB')->dropDownList(
                    ArrayHelper::map(Nhomtbi::find()->all(), 'ID_NHOM', 'TEN_NHOM'),
                    [
                        'options' => [@$_GET['id'] => ['Selected'=>'selected']],
                        'prompt' => 'Chọn nhóm thiết bị'
                    ]) ?>
            </div>
            <div class="col-sm-3">                
                <?= $form->field($model, 'HANGSX')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">                
                <?= $form->field($model, 'THONGSOKT')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'PHUKIEN')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-edit"></i> Sửa', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
