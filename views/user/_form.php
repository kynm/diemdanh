<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Role;
use app\models\BoPhan;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
	    <div class="box-body">
	        <div class="col-sm-4">
    			<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
	        </div>
	        	
	        <div class="col-sm-4">
    			<?= $form->field($model, 'password')->passwordInput(['minlength' => 5]) ?>
	        </div>
	        	
	        <div class="col-sm-4">
    			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
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
