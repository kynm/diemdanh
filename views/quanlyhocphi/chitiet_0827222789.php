<?php
?>
<div>
    <table class="table">
        <tbody>
            <tr class="text-center">
                <th class="text-center" style="width: 25%;">
                    <h4>LỚP TIẾNG ANH <?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI)?></h4>
                    <h6><?=mb_strtoupper(Yii::$app->user->identity->nhanvien->iDDONVI->DIA_CHI)?></h6>
                </th>
                <th class="text-center" style="width: 45%;">
                    <h3>THÔNG BÁO HỌC PHÍ THÁNG</h3>
                    <h6><?= mb_strtoupper($model->hocphi->TIEUDE)?></h6>
                    <h5>CÁM ƠN QUÝ ANH CHỊ ĐÃ TIN TƯỞNG VÀ ĐỒNG HÀNH</h5>
                </th>
                <th>
                    <img src="data:image/jpeg;base64,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" width="120px">
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
                <td style="border: 1px solid;">THÔNG TIN THANH TOÁN</td>
                <td style="border: 1px solid;text-align: center;">
                    <?= nl2br(Yii::$app->user->identity->nhanvien->iDDONVI->TTTT)?>
                    NỘI DUNG CHUYỂN KHOẢN: <?= $model->hocsinh->HO_TEN?>_<?= $model->hocphi->lop->TEN_LOP?>_<?= mb_strtoupper($model->hocphi->TIEUDE)?>
                </td>
                <td style="border: 1px solid;min-width: 300px;">
                    <?php if(Yii::$app->user->identity->nhanvien->iDDONVI->linkqr):
                        $addInfo = $model->hocsinh->HO_TEN . ' ' . $model->hocphi->lop->TEN_LOP . ' ' . mb_strtoupper($model->hocphi->TIEUDE);
                        $addInfo = preg_replace('/[\x00-\x1F\x7F]/u', '', $addInfo);
                    ?>
                        <img height="400" width="300" src="<?= Yii::$app->user->identity->nhanvien->iDDONVI->linkqr . '?amount=' . $tongtien . '&&addInfo=' . $addInfo?>">
                    <?php endif; ?>
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