<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="box box-primary">
	    <div class="box-body">
	        <div class="col-sm-3">
    			<?= $form->field($model, 'activity_type')->textInput(['maxlength' => true]) ?>
	        </div>
	        	
	        <div class="col-sm-5">
    			<?= $form->field($model, 'activity_name')->textInput(['maxlength' => true]) ?>
	        </div>
	        	
	        <div class="col-sm-4">
    			<?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>
	        </div>
	    </div>
	        	
	    <div class="box-footer">
		    <div class="text-center">
		        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		    </div>
	    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
