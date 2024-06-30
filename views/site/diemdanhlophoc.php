<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
	<?php foreach ($dslop as $key => $lop):?>
	<div class="col-lg-3 col-6">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<?= Html::a($lop->TEN_LOP, ['/lophoc/view', 'id' => $lop->ID_LOP], ['class' => 'info-box-number']) ?>
				<span class="info-box-number"  style="font-size: 20px; color: red;"><?= $lop->getDshocsinh()->count()?> Học viên</span>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
