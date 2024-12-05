<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
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
                <th class="text-center">Họ tên</th>
                <th class="text-center">Lớp</th>
                <th class="text-center">NGÀY HỌC</th>
                <th class="text-center">NGÀY NGHỈ</th>
                <th class="text-center">TIỀN HỌC</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <tr class="text-center">
            	<td style="border: 1px solid; width: 15%;"><?= $model->hocsinh->HO_TEN?><br><?= $model->hocsinh->SO_DT?><br><?= $model->hocsinh->DIA_CHI?></td>
            	<td style="border: 1px solid; width: 15%;"><?= $model->hocphi->lop->TEN_LOP?></td>
                <td style="border: 1px solid; width: 15%;"><?= $model->NGAYDIHOC?></td>
                <td style="border: 1px solid; width: 15%;"><?= $model->NGAY_NGHI?></td>
            	<td style="border: 1px solid; width: 7%;"><?= $model->TONG_TIENHOC?></td>
                <td style="border: 1px solid; width: 7%;"><?= number_format($model->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= number_format($model->TONG_TIEN)?></td>
                <td style="border: 1px solid; width: 20%;"><?= nl2br($model->NHAN_XET)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= statusthutien()[$model->STATUS]?></td>
            </tr>
            <tr>
            	<td colspan="9" style="border: 1px solid;">
            		<b>1. Kính gửi quý phụ huynh <?= $model->hocphi->TIEUDE?>!</b><br>
					<?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) : ''?>

            	</td>
            </tr>
            <tr>
            	<td colspan="9" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) : ''?>
            	</td>
            </tr>
            <tr>
            	<td colspan="9" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) : ''?>
            	</td>
            </tr>
        </tbody>
    </table>
</div>
<pagebreak />