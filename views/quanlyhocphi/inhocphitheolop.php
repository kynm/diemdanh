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
                <th class="text-center">Họ tên</th>
                <th class="text-center">SĐT</th>
                <th class="text-center">Địa chỉ</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet): ?>
            <tr class="text-center">
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->HO_TEN?></td>
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->SO_DT?></td>
            	<td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->DIA_CHI?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TONG_TIEN)?></td>
                <td style="border: 1px solid; width: 20%;"><?= nl2br($chitiet->NHAN_XET)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= statusthutien()[$chitiet->STATUS]?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>