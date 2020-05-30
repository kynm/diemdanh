<?php

use yii\helpers\Html;
use app\components\ArrHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramvtSearch */
/* @var $form yii\widgets\ActiveForm */
$tongtien = 0;
?>

<div class="table-responsive">
        <h4>II. Tổng hợp tiền điện theo số tài khoản </h4>
    <table class="table">
        <thead>
          <tr>
            <th scope="col" width="2%">STT</th>
            <th scope="col" width="20%">Tên TTVT</th>
            <th scope="col" width="10%">Số trạm thanh toán</th>
            <th scope="col" width="10%">Số tiền chưa thuế</th>
            <th scope="col" width="10%">Thuế VAT</th>
            <th scope="col" width="10%">Tổng tiền</th>
            <th scope="col" width="10%">Tiền đề nghị thanh toán</th>
          </tr>
        </thead>
        <tbody>
            <?php 
            $tongchuathue = 0;
            $tongthue = 0;
            $tongtien = 0;
            $tongdv = 0;
            foreach ($tongdiendv as $key => $value): ?>
                <tr>
                    <th scope="col"><?php echo ($key + 1);?></th>
                    <th scope="col"><?php echo $value['TEN_DONVI'];?></th>
                    <th scope="col"><?php echo $value['SO_TRAM'];?></th>
                    <th scope="col"><?php echo number_format($value['TIENDIEN']);?></th>
                    <th scope="col"><?php echo number_format($value['TIENTHUE']);?></th>
                    <th scope="col"><?php echo number_format($value['TONGTIEN']);?></th>
                    <th scope="col"><?php echo number_format($value['TONGTIEN']);?></th>
                    <?php
                        $tongchuathue += $value['TIENDIEN'];
                        $tongthue += $value['TIENTHUE'];
                        $tongtien += $value['TONGTIEN'];
                        $tongdv += $value['SO_TRAM'];
                    ?>
                </tr>
            <?php endforeach; ?>
          <tr>
            <th scope="col">Tổng</th>
            <th scope="col"></th>
            <th scope="col"><?php echo number_format($tongdv);?></th>
            <th scope="col"><?php echo number_format($tongchuathue);?></th>
            <th scope="col"><?php echo number_format($tongthue);?></th>
            <th scope="col"><?php echo number_format($tongtien);?></th>
            <th scope="col"><?php echo number_format($tongtien);?></th>
            <th scope="col"></th>
          </tr>
        </tbody>
    </table>
    <h4>II. Tổng hợp tiền điện theo số tài khoản </h4>
    <table class="table">
        <thead>
          <tr>
            <th scope="col" width="2%">STT</th>
            <th scope="col" width="20%">Tên đơn vị hưởng</th>
            <th scope="col" width="7%">Số tài khoản</th>
            <th scope="col" width="7%">Số tiền chưa thuế</th>
            <th scope="col" width="5%">Thuế VAT</th>
            <th scope="col" width="7%">Tổng tiền</th>
            <th scope="col" width="20%">Tên đơn vị hưởng</th>
            <th scope="col" width="7%">Số tài khoản</th>
            <th scope="col" width="20%">Tại ngân hàng</th>
          </tr>
        </thead>
        <tbody>
            <?php 
            $tongchuathue = 0;
            $tongthue = 0;
            $tongtien = 0;
            foreach ($tongdiennh as $key => $value): ?>
                <tr>
                    <th scope="col"><?php echo ($key + 1);?></th>
                    <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                    <th scope="col"><?php echo number_format($value['T_TIENDIEN']);?></th>
                    <th scope="col"><?php echo number_format($value['T_TIENTHUE']);?></th>
                    <th scope="col"><?php echo number_format($value['T_TONGTIEN']);?></th>
                    <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['NH_DIENLUC'];?></th>
                    <?php
                        $tongchuathue += $value['T_TIENDIEN'];
                        $tongthue += $value['T_TIENTHUE'];
                        $tongtien += $value['T_TONGTIEN'];
                    ?>
                </tr>
            <?php endforeach; ?>
          <tr>
            <th scope="col">Tổng</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"><?php echo number_format($tongchuathue);?></th>
            <th scope="col"><?php echo number_format($tongthue);?></th>
            <th scope="col"><?php echo number_format($tongtien);?></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </tbody>
    </table>
    <h4>III. Chi tiết tiền điện theo từng trạm</h4>
    <table class="table">
        <thead>
          <tr>
            <th scope="col" width="2%">STT</th>
            <th scope="col" width="10%">Mã khách hàng <br/>trên hóa đơn điện</th>
            <th scope="col" width="10%">Mã CSHT</th>
            <th scope="col" width="5%">Số tiền chưa thuế</th>
            <th scope="col" width="5%">Thuế VAT</th>
            <th scope="col" width="5%">Tổng tiền</th>
            <th scope="col" width="5%">Tổng tiền đề xuất</th>
            <th scope="col" width="10%">Tên đơn vị hưởng</th>
            <th scope="col" width="5%">Số tài khoản</th>
            <th scope="col" width="10%">Tại ngân hàng</th>
            <th scope="col" width="3%">Mã đơn vị</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($dssddien as $key => $value): ?>
                <tr>
                    <th scope="col"><?php echo ($key + 1);?></th>
                    <th scope="col"><?php echo $value['MA_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['MA_CSHT'];?></th>
                    <th scope="col"><?php echo number_format($value['TIENDIEN']);?></th>
                    <th scope="col"><?php echo number_format($value['TIENTHUE']);?></th>
                    <th scope="col"><?php echo number_format($value['TONGTIEN']);?></th>
                    <th scope="col"><?php echo number_format($value['TONGTIEN']);?></th>
                    <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['NH_DIENLUC'];?></th>
                    <th scope="col"><?php echo $value['MA_DONVIKT'];?></th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
