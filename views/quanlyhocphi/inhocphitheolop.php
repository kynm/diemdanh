<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ THEO LỚP';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-body table-responsive">
    <h2 class="text-center"><b>THÔNG BÁO  <?= mb_strtoupper($model->TIEUDE)?></b>
	<h2 class="text-center"><b>LỚP <?= mb_strtoupper($model->lop->TEN_LOP)?></b>
    </h2>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Tên con</th>
                <th class="text-center">Ngày học</th>
                <th class="text-center">Ngày nghỉ</th>
                <th class="text-center">TIỀN HỌC</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet): ?>
            <tr class="text-center">
            	<td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->HO_TEN?><br><?= $chitiet->hocsinh->SO_DT?><br><?= $chitiet->hocsinh->DIA_CHI?></td>
            	<td style="border: 1px solid; width: 7%;"><?= $chitiet->NGAYDIHOC?></td>
                <td style="border: 1px solid; width: 7%;"><?= $chitiet->NGAY_NGHI?></td>
            	<td style="border: 1px solid; width: 10%;"><?= number_format($chitiet->TIENHOC * $chitiet->SO_BTT)?></td>
                <td style="border: 1px solid; width: 10%;"><?= number_format($chitiet->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= number_format($chitiet->TONG_TIEN)?></td>
                <td style="border: 1px solid; width: 20%;"><?= nl2br($chitiet->NHAN_XET)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= statusthutien()[$chitiet->STATUS]?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>