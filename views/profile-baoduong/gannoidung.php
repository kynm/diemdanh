<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileBaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gán nội dung cho Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-baoduong--gannoidung-index">
	<div class="col col-sm-5">
		<div class="box box-primary">
		    <div class="box-header with-border">
		        <h3 class="box-title">Nội dung</h3>
		    </div>
		    <div class="box-body" style="overflow: auto; height: 400px;">
		        <div class="panel-group" id="chuachon">
		        	<?php foreach ($result as $key => $element) { ?>
			            <div class="panel panel-default">
			                <div class="panel-heading">
			                    <h4 class="panel-title">
			                        <b><a data-toggle="collapse" data-parent="#chuachon" href="#<?= $key ?>_chuachon"><?= $element['TEN_NHOM'] ?></a></b>
			                    </h4>
			                </div>
			                <div id="<?= $key ?>_chuachon" class="panel-collapse collapse">
			                    <ul class="list-group">
			                    	<?php foreach ($element['DS_ND'] as $ND) { 
			                    		echo is_null($ND['ID_PROFILE']) ? '
			                    			<li class="list-group-item">
			                    				<input type="checkbox" value="'.$ND['MA_NOIDUNG'].'">
			                    				'.$ND['NOIDUNG'].'
			                    			</li>' : '';
			                    	} ?>
			                    </ul>
			                </div>
			            </div>
		        	<?php } ?>
		        </div>
		    </div>
		</div>
	</div>
	<div class="col col-sm-5">
		<div class="box box-primary">
		    <div class="box-header with-border">
		        <h3 class="box-title">Nội dung đã chọn</h3>
		    </div>
		    <div class="box-body" style="overflow: auto; height: 400px;">
		        <div class="panel-group" id="dachon">
		        	<?php foreach ($result as $key => $element) { ?>
			            <div class="panel panel-default">
			                <div class="panel-heading">
			                    <h4 class="panel-title">
			                        <b><a data-toggle="collapse" data-parent="#dachon" href="#<?= $key ?>_dachon"><?= $element['TEN_NHOM'] ?></a></b>
			                    </h4>
			                </div>
			                <div id="<?= $key ?>_dachon" class="panel-collapse collapse">
			                    <ul class="list-group">
			                    	<?php foreach ($element['DS_ND'] as $ND) { 
			                    		echo !is_null($ND['ID_PROFILE']) ? '<li class="list-group-item">'.$ND['NOIDUNG'].'</li>' : '';
			                    	} ?>
			                    </ul>
			                </div>
			            </div>
		        	<?php } ?>
		        </div>
		    </div>
		</div>
	</div>
</div>
<?php
$script = <<< JS
    $(".list-group").each(function()
	{
	    if($(this).children(".list-group-item").length == 0)
	    {
	        $(this).parents().eq(1).hide();
	    }
	});
JS;
$this->registerJs($script);
?>