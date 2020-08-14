<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\file\FileInput;
?>

<div class="import-hopdong-form">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-md-2 col-xs-2">
                    <?= $form->field($model, 'fileupload')->fileInput();?>
                </div>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i> Import', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'searchBtn',
                        
                    ])
                ?>
            </div>
        </div>     
        
        <?php ActiveForm::end(); ?>
</div>

