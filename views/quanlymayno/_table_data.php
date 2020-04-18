<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramvtSearch */
/* @var $form yii\widgets\ActiveForm */
$tongtien = 0;
?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
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
                  <tr>
                    <?php foreach ($data as $value): ?>
                    <td><?php echo $value->tRAMVANHANH->TEN_TRAM;?></td>
                    <td><?php echo $value->tHIETBITRAM->iDLOAITB->TEN_THIETBI;?></td>
                    <td>Cell</td>
                    <?php
                        $dinhmuc = json_decode($value->tHIETBITRAM->THAMSOTHIETBI)->DINH_MUC;
                        $LOAINHIENLIEU = json_decode($value->tHIETBITRAM->THAMSOTHIETBI)->LOAINHIENLIEU;
                        $expectedStartTime = new DateTime($value->THOIGIANBATDAU);
                        $expectedEndTime = new DateTime($value->THOIGIANKETTHUC);
                        $diff = $expectedEndTime->diff($expectedStartTime, true);
                        $hous = ($diff->i + ($diff->h*60)+ ($diff->d*24*60));
                        $soluong = $hous * $dinhmuc / 60;
                        $thanhtien = $dongiamayno[$LOAINHIENLIEU] * $soluong;
                        $tongtien +=$thanhtien;
                    ?>
                    <td><?php echo $dinhmuc?></td>
                    <td><?php echo $hous;?></td>
                    <td><?php echo $soluong;?></td>
                    <td><?php echo $dongiamayno[$LOAINHIENLIEU];?></td>
                    <td><?php echo $thanhtien?></td>
                  </tr>
                  <?php endforeach; ?>
                    <tr>
                    <th scope="col">Tổng tiền</th>
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
            </div>
        </div>
    </div>
</div>