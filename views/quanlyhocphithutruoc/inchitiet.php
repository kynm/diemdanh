<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-body table-responsive">
    <h2 class="text-center"><?= Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI?></h2>
    <h3 class="text-center">THÔNG BÁO <?= mb_strtoupper($model->TIEUDE)?></h3>
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Họ tên</th>
                <th class="text-center">Lớp</th>
                <th class="text-center">TIỀN HỌC</th>
                <th class="text-center">HỌC BỔNG/ MIỄN GIẢM</th>
                <th class="text-center">TIỀN SÁCH/ TÀI LIỆU</th>
                <th class="text-center">TỔNG TIỀN</th>
                <th class="text-center">GHI CHÚ</th>
            </tr>
            <tr class="text-center">
            	<td style="border: 1px solid; width: 15%;"><?= $model->hocsinh->HO_TEN?><br><?= $model->hocsinh->SO_DT?><br><?= $model->hocsinh->DIA_CHI?></td>
            	<td style="border: 1px solid; width: 15%;"><?= $model->lop->TEN_LOP?></td>
                <td style="border: 1px solid; width: 7%;"><?= number_format($model->SOTIEN)?></td>
            	<td style="border: 1px solid; width: 7%;"><?= number_format($model->TIENGIAM)?></td>
                <td style="border: 1px solid; width: 7%;"><?= number_format($model->TIENKHAC)?></td>
            	<td style="border: 1px solid; width: 10%;"><?= number_format($model->TONGTIEN)?></td>
                <td style="border: 1px solid; width: 20%;"><?= nl2br($model->GHICHU)?></td>
            </tr>
            <tr>
                <td colspan="7" style="border: 1px solid;">
                    <?php if ($model->NGAY_KT):?>
                        NGÀY BẮT ĐẦU: <?= Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y')?><br/>
                        NGÀY KẾT THÚC: <?= Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y')?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
					<?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT) : ''?>

            	</td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH) : ''?>
            	</td>
            </tr>
            <tr>
            	<td colspan="7" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) : ''?>
            	</td>
            </tr>
        </tbody>
    </table>
</div>