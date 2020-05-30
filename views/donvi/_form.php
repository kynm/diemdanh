<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donvi-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'MA_DONVI')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'MA_DONVIKT')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-4">
                    <?= $form->field($model, 'TEN_DONVI')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-4">
                    <?= $form->field($model, 'DIA_CHI')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'SO_DT')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-md-4">
                    <?= $form->field($model, 'CAP_TREN')->dropDownList(
                        ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'),
                        ['prompt' => 'Chọn đơn vị cấp trên']
                    ) ?>
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
