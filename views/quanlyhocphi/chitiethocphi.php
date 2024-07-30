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
                <th >Tên con</th>
                <th >Lớp</th>
                <th >Ngày học</th>
                <th >Ngày nghỉ</th>
                <th >TỔNG TIỀN</th>
                <th >GHI CHÚ</th>
            </tr>
            <tr class="text-center">
            	<td style="border: 1px solid;"><?= $model->hocsinh->HO_TEN?></td>
            	<td style="border: 1px solid;"><?= $model->hocphi->lop->TEN_LOP?></td>
            	<td style="border: 1px solid;"><?= $model->NGAYDIHOC?></td>
            	<td style="border: 1px solid;"><?= $model->NGAY_NGHI?></td>
            	<td style="border: 1px solid;"><?= number_format($model->TONG_TIEN)?></td>
            	<td style="border: 1px solid;"><?= nl2br($model->NHAN_XET)?></td>
            </tr>
            <tr>
            	<td colspan="6" style="border: 1px solid;">
            		<b>1. Kính gửi quý phụ huynh <?= $model->hocphi->TIEUDE?> của con!</b><br>
					<?=  isset($model->hocphi->lop->iDDONVI->TTTT) ? nl2br($model->hocphi->lop->iDDONVI->TTTT) : ''?>

            	</td>
            </tr>
            <tr>
            	<td colspan="6" style="border: 1px solid;">
                    <?=  isset($model->hocphi->lop->iDDONVI->QDLH) ? nl2br($model->hocphi->lop->iDDONVI->QDLH) : ''?>
            	</td>
            </tr>
            <tr>
            	<td colspan="6" style="border: 1px solid;">
                    <?=  isset($model->hocphi->lop->iDDONVI->TTLH) ? nl2br($model->hocphi->lop->iDDONVI->TTLH) : ''?>
            	</td>
            </tr>
        </tbody>
    </table>
</div>