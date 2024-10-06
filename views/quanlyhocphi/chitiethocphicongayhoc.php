<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-body table-responsive">
	<h3 class="text-center"><b>THÔNG BÁO  <?= mb_strtoupper($model->hocphi->TIEUDE)?></b>
    <?php if ($model->STATUS):?>
        <span class="btn btn-flat btn-success">Đã thu</span>
    <?php endif; ?>
    </h3>
    <table class="table table-bordered" style="font-size: 18px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center" style="width: 15%;">Họ tên</th>
                <th class="text-center" style="width: 10%;">Lớp</th>
                <th class="text-center" style="width: 15%;">Ngày học</th>
                <th class="text-center" style="width: 15%;">Ngày nghỉ</th>
                <th class="text-center" style="width: 10%;">Tiền học</th>
                <th class="text-center" style="width: 15%;">Tiền sách/ Tài liệu</th>
                <th class="text-center" style="width: 10%;">Tổng tiền</th>
                <th class="text-center" style="width: 20%;">Nhận xét</th>
            </tr>
            <tr class="text-center">
            	<td style="border: 1px solid;"><?= $model->hocsinh->HO_TEN?></td>
            	<td style="border: 1px solid;"><?= $model->hocphi->lop->TEN_LOP?></td>
                <td style="border: 1px solid;"><?= $model->NGAYDIHOC?></td>
                <td style="border: 1px solid;"><?= $model->NGAY_NGHI?></td>
            	<td style="border: 1px solid;"><?= $model->TONG_TIENHOC?></td>
                <td style="border: 1px solid;"><?= number_format($model->TIENKHAC)?></td>
            	<td style="border: 1px solid;"><?= number_format($model->TONG_TIEN)?></td>
                <td style="border: 1px solid;"><?= nl2br($model->NHAN_XET)?></td>
            </tr>
            <?php if($hocphichuathukhac):?>
                <?php $tongtien = $model->TONG_TIEN?>
                <?php foreach ($hocphichuathukhac as $key => $hp):?>
                    <?php $tongtien += $hp->TONG_TIEN?>
                    <tr class="text-center">
                        <td style="border: 1px solid; width: 15%;"><?= $hp->hocphi->TIEUDE?></td>
                        <td style="border: 1px solid; width: 15%;"></td>
                        <td style="border: 1px solid; width: 15%;"></td>
                        <td style="border: 1px solid; width: 15%;"></td>
                        <td style="border: 1px solid; width: 7%;"><?= $hp->TONG_TIENHOC?></td>
                        <td style="border: 1px solid; width: 7%;"><?= number_format($hp->TIENKHAC)?></td>
                        <td style="border: 1px solid; width: 10%;"><?= number_format($hp->TONG_TIEN)?></td>
                        <td style="border: 1px solid; width: 20%;"><?= nl2br($hp->NHAN_XET)?></td>
                    </tr>
                <?php endforeach;?>
                <tr class="text-center" style="border: 1px solid;">
                    <td colspan="6">Tổng tiền</td>
                    <td style="border: 1px solid;"><?= number_format($tongtien)?></td>
                    <td></td>
                </tr>
            <?php endif;?>
            <tr>
            	<td colspan="8" style="border: 1px solid;">
            		<b>1. Kính gửi quý phụ huynh <?= $model->hocphi->TIEUDE?>!</b><br>
					<?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) : ''?>

            	</td>
            </tr>
            <tr>
            	<td colspan="8" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) : ''?>
            	</td>
            </tr>
            <tr>
            	<td colspan="8" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) : ''?>
            	</td>
            </tr>
        </tbody>
    </table>
</div>
<pagebreak />