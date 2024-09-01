<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
    <?php if ($dslop):?>
	<?php foreach ($dslop as $key => $lop):?>
	<div class="col-lg-3 col-6">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<?= Html::a($lop->TEN_LOP, ['/lophoc/quanlydiemdanh', 'id' => $lop->ID_LOP], ['class' => 'info-box-number']) ?>
				<span class="info-box-number"  style="font-size: 20px; color: red;"><?= $lop->getDshocsinh()->where(['STATUS' => 1])->count()?> Học viên</span>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
    <?php else:?>
    	<h5 class="info-box-number" style="color: red"><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>TÀI KHOẢN CỦA BẠN ĐANG KHÔNG ĐƯỢC GIAO ĐIỂM DANH LỚP NÀO, VUI LÒNG LIÊN HỆ VỚI QUẢN LÝ CỦA BẠN</h5>
    <?php endif;?>
</div>
