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
    <table class="table">
        <tbody>
            <tr class="text-center">
                <th class="text-center" style="width: 25%;">
                    <img src="data:image/jpeg;base64,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">
                </th>
                <th class="text-center" style="width: 60%;">
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
