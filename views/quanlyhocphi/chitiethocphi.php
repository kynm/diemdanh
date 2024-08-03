<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-body table-responsive">
	<h2 class="text-center"><b>THÔNG BÁO  <?= mb_strtoupper($model->hocphi->TIEUDE)?></b>
    <?php if ($model->STATUS):?>
        <span class="btn btn-flat btn-success">Đã thu</span>
    <?php endif; ?>
    </h2>
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Tên con</th>
                <th class="text-center">Lớp</th>
                <th class="text-center">Ngày học</th>
                <th class="text-center">Ngày nghỉ</th>
                <th class="text-center">TIỀN HỌC/BUỔI</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
            </tr>
            <tr class="text-center">
            	<td style="border: 1px solid; width: 10%;"><?= $model->hocsinh->HO_TEN?></td>
            	<td style="border: 1px solid; width: 20%;"><?= $model->hocphi->lop->TEN_LOP?></td>
            	<td style="border: 1px solid; width: 7%;"><?= $model->NGAYDIHOC?></td>
                <td style="border: 1px solid; width: 7%;"><?= $model->NGAY_NGHI?></td>
            	<td style="border: 1px solid; width: 16%;"><?= number_format($model->TIENHOC)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= number_format($model->TONG_TIEN)?></td>
            	<td style="border: 1px solid; width: 30%;"><?= nl2br($model->NHAN_XET)?></td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
            		<b>1. Kính gửi quý phụ huynh <?= $model->hocphi->TIEUDE?> của con!</b><br>
					<?=  isset($model->hocphi->lop->iDDONVI->TTTT) ? nl2br($model->hocphi->lop->iDDONVI->TTTT) : ''?>

            	</td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
                    <?=  isset($model->hocphi->lop->iDDONVI->QDLH) ? nl2br($model->hocphi->lop->iDDONVI->QDLH) : ''?>
            	</td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
                    <?=  isset($model->hocphi->lop->iDDONVI->TTLH) ? nl2br($model->hocphi->lop->iDDONVI->TTLH) : ''?>
            	</td>
            </tr>
        </tbody>
    </table>
</div>