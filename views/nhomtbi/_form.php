<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nhomtbi-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
	    <div class="box-body">
	        <div class="col-sm-6">
	    		<?= $form->field($model, 'MA_NHOM')->textInput(['maxlength' => true]) ?>
	        </div>
	        	
	        <div class="col-sm-6">
	    		<?= $form->field($model, 'TEN_NHOM')->textInput(['maxlength' => true]) ?>
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
