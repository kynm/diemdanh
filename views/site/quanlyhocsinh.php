<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
	<div class="col-lg-3 col-6">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-number"  style="font-size: 20px; color: red;"><?= $solop?> LỚP HỌC</span>
				<?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH LỚP HỌC', ['/lophoc/index'], ['class' => 'small-box-footer']) ?>
			</div>
		</div>
	</div>
</div>
