<?php
?>
<div>
    <table class="table">
        <tbody>
            <tr class="text-center">
                <th class="text-center" style="width: 25%;">
                    <h4><?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI)?></h4>
                    <h6><?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->DIA_CHI)?></h6>
                </th>
                <th class="text-center" style="width: 45%;">
                    <h3>THÔNG BÁO HỌC PHÍ THÁNG</h3>
                    <h6><?= mb_strtoupper($model->hocphi->TIEUDE)?></h6>
                    <h5>CÁM ƠN QUÝ ANH CHỊ ĐÃ TIN TƯỞNG VÀ ĐỒNG HÀNH</h5>
                </th>
                <th>
                    <img src="data:image/jpeg;base64,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">
                </th>
            </tr>
            <tr>
                <td style="border: 1px solid;">TÊN</td>
            	<td colspan="2" style="border: 1px solid;"><?= $model->hocsinh->HO_TEN?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">LỚP</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->hocphi->lop->TEN_LOP?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">NGÀY HỌC</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->NGAYDIHOC?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">NGÀY NGHỈ</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->NGAY_NGHI?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;"><?= mb_strtoupper($model->hocphi->TIEUDE)?></td>
                <td colspan="2" style="border: 1px solid;">
                    <?= number_format($model->TONG_TIEN)?> (ĐỒNG) <?= $model->TIENKHAC ? ' - ĐÃ BAO GỒM TIỀN SÁCH/TÀI LIỆU: ' . number_format($model->TIENKHAC) . ' (ĐỒNG) ' : ''?>
                    <?php if ($model->STATUS):?>
                        <span class="btn btn-flat btn-success">Đã thu</span>
                    <?php endif; ?>
                    </td>
            </tr>
            <?php if($hocphichuathukhac):?>
                <?php $tongtien = $model->TONG_TIEN?>
                <?php foreach ($hocphichuathukhac as $key => $hp):?>
                    <?php $tongtien += $hp->TONG_TIEN?>
                    <tr>
                        <td style="border: 1px solid;"><?= mb_strtoupper($hp->hocphi->TIEUDE)?></td>
                        <td colspan="2" style="border: 1px solid;"><?= number_format($hp->TONG_TIEN)?> (ĐỒNG)
                            <?= $model->TIENKHAC ? ' - ĐÃ BAO GỒM TIỀN SÁCH/TÀI LIỆU: ' . number_format($hp->TIENKHAC) . ' (ĐỒNG) ' : ''?>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr style="border: 1px solid;">
                    <td>TỔNG TIỀN</td>
                    <td colspan="2" style="border: 1px solid;"><?= number_format($tongtien) . ' (ĐỒNG)'?></td>
                </tr>
            <?php endif;?>
            <tr>
                <td style="border: 1px solid;">THÔNG TIN THANH TOÁN</td>
                <td colspan="2" style="border: 1px solid;">
                    <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid;">NỘI DUNG CHUYỂN KHOẢN</td>
                <td colspan="2" style="border: 1px solid;"><?= $model->hocsinh->HO_TEN?>_<?= $model->hocphi->lop->TEN_LOP?>_<?= mb_strtoupper($model->hocphi->TIEUDE)?></td>
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