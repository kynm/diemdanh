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
    <table class="table table-bordered" style="font-size:18px">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Họ tên</th>
                <th class="text-center">SĐT</th>
                <th class="text-center">Địa chỉ</th>
                <th class="text-center">Từ ngày</th>
                <th class="text-center">Đến ngày</th>
                <th class="text-center">Tiền học</th>
                <th class="text-center">Miễn giảm/ Học bổng</th>
                <th class="text-center">Tiền sách/Tài liệu</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center">GHI CHÚ</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet): ?>
            <tr class="text-center">
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->HO_TEN?></td>
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->SO_DT?></td>
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->DIA_CHI?></td>
                <td style="border: 1px solid; width: 8%;"><?= $chitiet->hocsinh->NGAY_BD?></td>
            	<td style="border: 1px solid; width: 8%;"><?= $chitiet->hocsinh->NGAY_KT?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->SOTIEN)?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TIENGIAM)?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TONGTIEN)?></td>
                <td style="border: 1px solid; width: 15%;"><?= nl2br($chitiet->GHICHU)?></td>
            	<td style="border: 1px solid; width: 5%;"><?= statusthutien()[$chitiet->STATUS]?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>