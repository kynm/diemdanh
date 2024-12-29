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
                <th class="text-center" style="width: 55%;">
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
