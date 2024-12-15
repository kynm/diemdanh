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
    <div class="text-center">
        <?php if(Yii::$app->user->identity->nhanvien->iDDONVI->linkqr):
            $addInfo = $model->lop->TEN_LOP . ' ' . mb_strtoupper($model->TIEUDE);
            $addInfo = preg_replace('/[\x00-\x1F\x7F]/u', '', $addInfo);
        ?>
            <img height="400" width="300" src="<?= Yii::$app->user->identity->nhanvien->iDDONVI->linkqr . '?amount=' . $model->TIENHOC . '&&addInfo=' . $addInfo?>">
        <?php endif; ?>
        <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
    </div>
    <table class="table table-bordered">
        <tbody style="color: black;font-size: 19px;">
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
            <?php if($dshocphithutruoc) :?>
            <tr>
                <td colspan="7">
                    HỌC PHÍ THEO KHÓA
                </td>
            </tr>
            <?php foreach ($dshocphithutruoc as $key => $chitiet1): ?>
            <tr class="text-center">
                <td style="border: 1px solid; width: 10%;"><?= $chitiet1->hocsinh->HO_TEN?></td>
                <td style="border: 1px solid; width: 10%;"><?= $chitiet1->hocsinh->SO_DT?></td>
                <td style="border: 1px solid; width: 10%;"><?= $chitiet1->hocsinh->DIA_CHI?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet1->TIENKHAC)?></td>
                <td style="border: 1px solid; width: 8%;"><?= number_format($chitiet1->TONGTIEN)?></td>
                <td style="border: 1px solid; width: 20%;"><?= nl2br($chitiet1->GHICHU)?></td>
                <td style="border: 1px solid; width: 10%;"><?= statusduyethocphithutruoc()[$chitiet1->STATUS]?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>