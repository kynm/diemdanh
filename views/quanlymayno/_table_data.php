<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramvtSearch */
/* @var $form yii\widgets\ActiveForm */
$tongtien = 0;
?>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Tên trạm</th>
                    <th scope="col">Loại máy nổ</th>
                    <th scope="col">Loại nhiên liệu</th>
                    <th scope="col">Tiêu hao (l/h)</th>
                    <th scope="col">Thời gian (phút)</th>
                    <th scope="col">Số lượng (L)</th>
                    <th scope="col">Đơn giá (VNĐ)</th>
                    <th scope="col">Thành tiền</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $dai): ?>
                        <?php if($dai['DU_LIEU']) :?>
                            <tr>
                                <td colspan="8" style="font-weight: bold;"><?php echo $dai['TEN_DAIVT']?></td>
                            </tr>
                            <?php $tong_theodai = 0;
                                foreach ($dai['DU_LIEU'] as $value): ?>
                                <tr>
                                    <td><?php echo $value->tRAMVANHANH->TEN_TRAM;?></td>
                                    <td><?php echo $value->tHIETBITRAM->iDLOAITB->TEN_THIETBI;?></td>
                                    <td>Cell</td>
                                    <?php
                                        $LOAINHIENLIEU = json_decode($value->tHIETBITRAM->THAMSOTHIETBI)->LOAINHIENLIEU;

                                        $thanhtien = $dongiamayno[$LOAINHIENLIEU] * $value->soluong;
                                        $thanhtien = round($thanhtien);
                                        $tongtien += $thanhtien;
                                        $tong_theodai += $thanhtien;
                                    ?>
                                    <td><?php echo json_decode($value->tHIETBITRAM->THAMSOTHIETBI)->DINH_MUC;?></td>
                                    <td><?php echo $value->hous;?></td>
                                    <td><?php echo $value->soluong;?></td>
                                    <td><?php echo $dongiamayno[$LOAINHIENLIEU];?></td>
                                    <td><?php echo $thanhtien?></td>
                                <tr>
                            <?php endforeach; ?>
                            <th scope="col">Cộng</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"><?php echo $tong_theodai?></th>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                    <th scope="col">Tổng cộng</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"><?php echo $tongtien?></th>
                    </tr>
                </tbody>
              </table>
