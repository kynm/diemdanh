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
                </th>
                <th>
                    <img src="">
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
                <td colspan="2" style="border: 1px solid;">
                    <?=   nl2br($model->NHAN_XET)?>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid;">THÔNG TIN THANH TOÁN</td>
                <td style="border: 1px solid;text-align: center;">
                    <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
                    NỘI DUNG CHUYỂN KHOẢN: <?= $model->hocsinh->HO_TEN?>_<?= $model->hocphi->lop->TEN_LOP?>_<?= mb_strtoupper($model->hocphi->TIEUDE)?>
                </td>
                <td style="border: 1px solid;min-width: 300px;">
                    <?php if(Yii::$app->user->identity->nhanvien->iDDONVI->linkqr):
                        $addInfo = $model->hocsinh->HO_TEN . ' ' . $model->hocphi->lop->TEN_LOP;
                        $addInfo = preg_replace('/[\x00-\x1F\x7F]/u', '', $addInfo);
                    ?>
                        <img height="300" width="250" src="<?= Yii::$app->user->identity->nhanvien->iDDONVI->linkqr . '?amount=' . $tongtien . '&&addInfo=' . $addInfo?>">
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid;">LIÊN HỆ</td>
                <td colspan="2" style="border: 1px solid;">
                    <?=  isset(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) ? nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTLH) : ''?>
                </td>
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