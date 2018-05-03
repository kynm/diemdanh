<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noidungbaotri-form">

    <div class="box box-primary">
    
        <?php $form = ActiveForm::begin(); ?>
    
        <div class="box-body">
            <div class="col-sm-6">
                <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'ID_THIETBI')->dropDownList(
                    ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
                    [
                        'prompt' => 'Chọn loại thiết bị',
                        'options' => [@$_GET['id'] => ['Selected'=>'selected']]
                    ]) ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'NOIDUNG')->textArea(['cols' => 6]) ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>            
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>


</div>
