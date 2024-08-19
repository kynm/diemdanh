<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '';
?>
<div class="row">
    <?php if (Yii::$app->user->identity->nhanvien->dshocsinh):?>
	<?php foreach (Yii::$app->user->identity->nhanvien->dshocsinh as $key => $hocsinh):?>
	<div class="col-lg-3 col-6">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-number" style="font-size: 20px; color: red;"><?= Html::a($hocsinh->HO_TEN, ['/quanlyphuhuynh/chitiethocsinh', 'mahs' => $hocsinh->MA_HOCSINH], ['class' => 'info-box-number']) ?></span>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
<?= $this->render('/quanlyphuhuynh/_news', [
	'dstintuc' => $dstintuc,
]) ?>
