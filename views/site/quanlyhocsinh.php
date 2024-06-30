<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= $solop?> LỚP HỌC</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH LỚP HỌC', ['/lophoc/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= $tongsohocvien?> HỌC VIÊN</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH HỌC VIÊN', ['/hocsinh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">ĐIỂM DANH</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH ĐIỂM DANH', ['/quanlydiemdanh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
</div>
<div class="box-body table-responsive">
    <h1>NGÀY HIỆN TẠI</h1>
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary">
                <th>LỚP</th>
                <th>TỔNG SỐ <br/>HỌC SINH</th>
                <th>SỐ HỌC SINH <br/>ĐI HỌC</th>
                <th>SỐ HỌC SINH <br/>VẮNG</th>
                <th>HỌC SINH VẮNG</th>
            </tr>
            <?php
                $SOHOCSINH = 0;
                $SOLUONGDIHOC = 0;
                $SOLUONGNGHI = 0;
                    foreach ($dulieungay as $key => $value):
                        $SOHOCSINH += $value['SOHOCSINH'];
                        $SOLUONGDIHOC += $value['SOLUONGDIHOC'];
                        $SOLUONGNGHI += $value['SOLUONGNGHI'];
                    ?>
                    <tr>
                        <td><?= $value['TEN_LOP']?></td>
                        <td><?= $value['SOHOCSINH']?></td>
                        <td><?= $value['SOLUONGDIHOC']?></td>
                        <td><?= $value['SOLUONGNGHI']?></td>
                        <td><?= $value['HOCSINHNGHI']?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="color:red">
                    <td>TỔNG</td>
                    <td><?= $SOHOCSINH?></td>
                    <td><?= $SOLUONGDIHOC?></td>
                    <td><?= $SOLUONGNGHI?></td>
                </tr>
        </tbody>
    </table>
</div>