<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramvtSearch */
/* @var $form yii\widgets\ActiveForm */
$tongtien = 0;
$tongphut = 0;
$tongnhienlieu = 0;
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
                                <td colspan="8" style="font-weight: bold;"><?php echo $dai['TEN_DONVI']?></td>
                            </tr>
                            <?php 
                                $tong_theodai = 0;
                                $tong_phuttheodai = 0;
                                $tong_nhienlieutheodai = 0;
                                foreach ($dai['DU_LIEU'] as $value): ?>
                                <tr>
                                    <td><?php echo $value['TEN_TRAM'];?></td>
                                    <td><?php echo $value['TEN_THIETBI'];?></td>
                                    <td><?php echo $loainhienlieu[$value['LOAINHIENLIEU']]?></td>
                                    <?php
                                        $thanhtien = $value['GIATIEN'] * ($value['DINHMUC'] * ($value['THOI_GIAN']/60));
                                        $tongtien += $thanhtien;
                                        $tong_theodai += $thanhtien;
                                        $tong_phuttheodai += $value['THOI_GIAN'];
                                        $tong_nhienlieutheodai += round($value['DINHMUC'] * ($value['THOI_GIAN']/60), 2);
                                        $tongphut += $value['THOI_GIAN'];
                                        $tongnhienlieu += round($value['DINHMUC'] * ($value['THOI_GIAN']/60), 2);
                                    ?>
                                    <td><?php echo $value['DINHMUC'];?></td>
                                    <td><?php echo $value['THOI_GIAN'];?></td>
                                    <td><?php echo round($value['DINHMUC'] * ($value['THOI_GIAN']/60), 2);?></td>
                                    <td><?php echo number_format($value['GIATIEN'] ,5);?></td>
                                    <td><?php echo number_format($thanhtien)?></td>
                                <tr>
                            <?php endforeach; ?>
                            <th scope="col">Cộng</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"><?php echo number_format($tong_phuttheodai)?></th>
                                <th scope="col"><?php echo number_format($tong_nhienlieutheodai)?></th>
                                <th scope="col"></th>
                                <th scope="col"><?php echo number_format($tong_theodai)?></th>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                    <th scope="col">Tổng cộng</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"><?php echo number_format($tongphut)?></th>
                        <th scope="col"><?php echo number_format($tongnhienlieu)?></th>
                        <th scope="col"></th>
                        <th scope="col"><?php echo number_format($tongtien)?></th>
                    </tr>
                </tbody>
              </table>
