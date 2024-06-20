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
				<span class="info-box-number"><?= $lop->TEN_LOP?></span>
				<span class="info-box-number"><?= $lop->getDshocsinh()->count()?> Học viên</span>
				<?= Html::a('<i class="fa fa-arrow-circle-right"></i> CHI TIẾT', ['/lophoc/view', 'id' => $lop->ID_LOP], ['class' => 'small-box-footer']) ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
