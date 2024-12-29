<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ';
$this->params['breadcrumbs'][] = $this->title;
?>
<pagebreak />
<div class="box-body table-responsive">
    <table class="table" style="font-size:20px">
        <tbody>
            <tr class="text-center">
                <th class="text-center" style="width: 25%;">
                    <img src="">
                </th>
                <th class="text-center" style="width: 45%;">
                    <h3>THÔNG BÁO HỌC PHÍ</h3>
                    <h6>TỪ NGÀY: <?= Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y')?>. ĐẾN NGÀY: <?= Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y')?></h6>
                </th>
                <th>
                    <h5 class="text-center"><?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI)?></h5>
                    <h6 class="text-center"><?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->DIA_CHI)?></h6>
                </th>
            </tr>
            <tr>
                <td style="border: 1px solid;">TÊN</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->hocsinh->HO_TEN?> - <?= $model->lop->TEN_LOP?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">NGÀY NGHỈ</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->dsngaynghihoc($model->NGAY_BD, $model->NGAY_KT)?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">SỐ BUỔI HỌC</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->sobuoidahoc($model->NGAY_BD, $model->NGAY_KT)?>/<?= $model->SO_BH?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">TỔNG TIỀN</td>
                <td colspan="2" style="border: 1px solid;">
                    <div style="font-size:20px"><?= number_format($model->TONGTIEN)?> (ĐỒNG) </div> <?= $model->TIENKHAC ? ' - ĐÃ BAO GỒM TIỀN SÁCH/TÀI LIỆU: ' . number_format($model->TIENKHAC) . ' (ĐỒNG) ' : ''?>
                    <?php if ($model->STATUS == 2):?>
                        <span class="btn btn-flat btn-success">Đã thu</span>
                    <?php endif; ?>
                    </td>
            </tr>
            <tr>
                <td style="border: 1px solid;">GHI CHÚ</td>
                <td colspan="2" style="border: 1px solid;"><?= nl2br($model->GHICHU)?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">THÔNG TIN THANH TOÁN</td>
                <td style="border: 1px solid;">
                    <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
                    <h4><b>NỘI DUNG CHUYỂN KHOẢN: <?= $model->hocsinh->HO_TEN?><?= $model->lop->TEN_LOP?></b></h4>
                </td>
                <td style="border: 1px solid;min-width: 300px;">
                    <?php if(Yii::$app->user->identity->nhanvien->iDDONVI->linkqr):
                        $addInfo = $model->hocsinh->HO_TEN . ' ' . $model->lop->TEN_LOP;
                        $addInfo = preg_replace('/[\x00-\x1F\x7F]/u', '', $addInfo);
                    ?>
                        <img height="250" width="200" src="<?= Yii::$app->user->identity->nhanvien->iDDONVI->linkqr . '?amount=' . $model->TONGTIEN . '&addInfo=' . $addInfo?>">
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid;">QUY ĐỊNH LỚP HỌC</td>
                <td colspan="2" style="border: 1px solid;"><?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->QDLH)?></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>
                    <p class="text-center">Người lập phiếu</p>
                    <p class="text-center">(Ký, họ tên)</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<pagebreak />
    <?php
    $danhsachkiemtra = $model->danhsachkiemtra;
    if($danhsachkiemtra): ?>
    <b><h3>ĐIỂM KIỂM TRA</h3></b>
    <table class="table table-bordered" style="font-size: 18px;">
        <tbody>
            <tr class="bg-primary text-center">
                <th class="text-center">Họ tên</th>
                <th class="text-center">Nghe</th>
                <th class="text-center">Nói</th>
                <th class="text-center">Đọc</th>
                <th class="text-center">Viết</th>
                <th class="text-center">Điểm</th>
                <th style="width: 20%;">Nhận xét</th>
                <th style="width: 30%;">Nhận xét chung</th>
            </tr>
            <?php foreach ($danhsachkiemtra as $key => $value):?>
                <tr>
                    <td><?=$value->hocsinh->HO_TEN ?></td>
                    <td><?=$value->NGHE ?></td>
                    <td><?=$value->NOI ?></td>
                    <td><?=$value->DOC ?></td>
                    <td><?=$value->VIET ?></td>
                    <td><?=$value->DIEM ?></td>
                    <td><?= nl2br($value->NHAN_XET) ?></td>
                    <td><?= nl2br($value->chamdiem->NOIDUNG) ?></td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
    <?php endif;?>
</div>
<pagebreak />
