<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Thuchienbd;


/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = 'Create Ketqua';
$this->params['breadcrumbs'][] = ['label' => 'Ketquas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ketqua-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ketqua-form">
	    <div class="col-md-6">
	    	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		    <div class="form-group col-md-12">
		        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
		    </div>

		    <p class="form-inline">
		        <div class="form-group col-md-3 col-sm-6">
		            <label>Trạm viễn thông</label>
		            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $dotbd->iDTRAMVT->MA_TRAM ; ?>">
		        </div>
		        <div class="form-group col-md-3 col-sm-6">
		            <label>Ngày bảo dưỡng</label>
		            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $dotbd->NGAY_BD ; ?>">
		        </div>
		        <div class="form-group col-md-3 col-sm-6">
		            <label>Nhóm trưởng</label>
		            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $dotbd->tRUONGNHOM->TEN_NHANVIEN ; ?>">
		        </div>
		        <div class="form-group col-md-3 col-sm-6">
		            <label>Trạng thái</label>
		            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $dotbd->TRANGTHAI ; ?>">
		        </div>
		    </p>
		    
		    	<?php
		    		$countAll = Thuchienbd::find()->where(['ID_DOTBD' => $dotbd->ID_DOTBD])->count();
		    		$countSuccess = Thuchienbd::find()->where(['ID_DOTBD' => $dotbd->ID_DOTBD, 'KETQUA' => 'Đạt' ])->count();
		    		$percent = 100*$countSuccess / $countAll;
		    	?>
			    
			    <div class="form-group col-md-12">
		            <label>Tiến độ</label>
		        	<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;">
						    <?= $percent ?>%
						</div>
					</div>    
		        </div>	    

			    <div class="col-md-12">
			    	<?= $form->field($model, 'KETQUA')->textInput() ?>
			    </div>
			    
			    <div class="col-md-12">
			    	<?= $form->field($model, 'GHICHU')->textArea() ?>
			    </div>
				
			    <div class="col-md-6 col-sm-6">
			        <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
			    </div>
			    	

		    <?php ActiveForm::end(); ?>
	    	
		</div>

	</div>

</div>
