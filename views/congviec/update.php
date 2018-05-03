<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thực hiện công việc';
$this->params['breadcrumbs'][] = ['label' => 'Thuchienbds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-create">

	<div class="thuchienbd-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <div class="box box-primary">
	        <div class="box-body">
	            <div class="col-sm-6 col-md-4">
	                <?= $form->field($model, 'ID_DOTBD')->textInput(['value' => $model->dOTBD->MA_DOTBD, 'disabled' => true]) ?>
	            </div>
	            
	            <div class="col-sm-6 col-md-4">
	                <?= $form->field($model, 'ID_THIETBI')->textInput(['value' => $model->tHIETBI->iDLOAITB->TEN_THIETBI, 'disabled' => true]) ?>
	            </div>
	            
	            <div class="col-sm-6 col-md-4">
	                <?= $form->field($model, 'MA_NOIDUNG')->textInput(['value' => $model->mANOIDUNG->NOIDUNG, 'disabled' => true]) ?>
	            </div>
	            
	            <div class="col-sm-6 col-md-4">
	                <?= $form->field($model, 'TRANGTHAI')->dropDownList([ 'Hoàn thành' => 'Hoàn thành', 'Chưa hoàn thành' => 'Chưa hoàn thành' ]) ?>
	            </div>
	            
	            <div class="col-sm-6 col-md-4">
	                <?= $form->field($model, 'GHICHU')->textInput(['maxlength' => true]) ?>
	            </div>
            
	        </div>
	        <div class="box-footer">
	            <div class="text-center">
	                <?= Html::submitButton('<i class="fa fa-check"></i> Hoàn thành', ['class' => 'btn btn-primary btn-flat']) ?>
	            </div>            
	        </div>
	    </div>



	    <?php ActiveForm::end(); ?>

	</div>


</div>
