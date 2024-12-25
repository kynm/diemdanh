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
                <th class="text-center" style="width: 55%;">
                    <h3>THÔNG BÁO HỌC PHÍ</h3>
                    <h6><?= mb_strtoupper($model->hocphi->TIEUDE)?></h6>
                </th>
                <th>
                    <img src="data:image/png;base64,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">
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
            <?php $tongtien = $model->TONG_TIEN?>
            <?php if($hocphichuathukhac):?>
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
                <td style="border: 1px solid;">GHI CHÚ</td>
                <td colspan="2" style="border: 1px solid;"><?= nl2br($model->NHAN_XET)?></td>
            </tr>
            <tr>
                <td style="border: 1px solid;">THÔNG TIN THANH TOÁN</td>
                <td style="border: 1px solid;text-align: center;">
                    <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
                    NỘI DUNG CHUYỂN KHOẢN: <?= $model->hocsinh->HO_TEN?><?= $model->hocphi->lop->TEN_LOP?>
                </td>
                <td style="border: 1px solid;min-width: 300px;">
                    <?php if(Yii::$app->user->identity->nhanvien->iDDONVI->linkqr):
                        $addInfo = $model->hocsinh->HO_TEN . ' ' . $model->hocphi->lop->TEN_LOP;
                        $addInfo = preg_replace('/[\x00-\x1F\x7F]/u', '', $addInfo);
                    ?>
                        <img height="250" width="200" src="<?= Yii::$app->user->identity->nhanvien->iDDONVI->linkqr . '?amount=' . $tongtien . '&&addInfo=' . $addInfo?>">
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