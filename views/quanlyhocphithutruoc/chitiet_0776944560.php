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
                    <img src="data:image/jpeg;base64,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">
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
                <td colspan="2" style="border: 1px solid;"><?= $model->sobuoidahoc($model->NGAY_BD, $model->NGAY_KT)?>/<?= $model->khoahoc->SO_BH?></td>
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
