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
	<h2 class="text-center"><b><?= Yii::$app->formatter->asDatetime($model->TU_NGAY, 'php:d/m/Y')?> - <?= Yii::$app->formatter->asDatetime($model->DEN_NGAY, 'php:d/m/Y')?></b>
    </h2>
    <table class="table table-bordered" style="font-size:25px">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Họ tên</th>
                <th class="text-center">Từ ngày</th>
                <th class="text-center">Tiền học</th>
                <th class="text-center">Miễn giảm/ Học bổng</th>
                <th class="text-center">Tiền sách/Tài liệu</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center"></th>
                <th style="width: 15%;">GHI CHÚ</th>
            </tr>
            <?php foreach ($model->chitiethocphi as $key => $chitiet): ?>
            <tr style="color: <?= $chitiet->STATUS == 1 ? 'red;' : 'black;' ?>">
                <td style="border: 1px solid; width: 10%;"><?= $chitiet->hocsinh->HO_TEN?></td>
                <td style="border: 1px solid; width: 8%;"><?= $chitiet->NGAY_BD?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->SOTIEN)?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TIENGIAM)?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 8%;"><?= number_format($chitiet->TONGTIEN)?></td>
            	<td style="border: 1px solid; width: 8%;"><?= statusdonhang()[$chitiet->STATUS]?></td>
                <td style="border: 1px solid; width: 10%;"><?= nl2br($chitiet->GHICHU)?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>