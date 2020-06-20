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
        <h4>I. Tổng hợp tiền điện theo trung tâm viễn thông </h4>
    <table>
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
                    <td><?php echo ($key + 1);?></td>
                    <td><?php echo $value['TEN_DONVI'];?></td>
                    <td><?php echo $value['SO_TRAM'];?></td>
                    <td><?php echo number_format($value['TIENDIEN'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TIENTHUE'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TONGTIEN'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TONGTIEN'], 0, ',', '.');?></td>
                    <?php
                        $tongchuathue += $value['TIENDIEN'];
                        $tongthue += $value['TIENTHUE'];
                        $tongtien += $value['TONGTIEN'];
                        $tongdv += $value['SO_TRAM'];
                    ?>
                </tr>
            <?php endforeach; ?>
          <tr>
            <td>Tổng</td>
            <td></td>
            <td><?php echo number_format($tongdv, 0, ',', '.');?></td>
            <td><?php echo number_format($tongchuathue, 0, ',', '.');?></td>
            <td><?php echo number_format($tongthue, 0, ',', '.');?></td>
            <td><?php echo number_format($tongtien, 0, ',', '.');?></td>
            <td><?php echo number_format($tongtien, 0, ',', '.');?></td>
          </tr>
        </tbody>
    </table>
    <h4>II. Tổng hợp tiền điện theo số tài khoản </h4>
    <table>
        <thead>
          <tr>
            <th scope="col" width="2%">STT</th>
            <th scope="col" width="20%">Tên đơn vị hưởng</th>
            <th scope="col" width="7%">Số tài khoản</th>
            <th scope="col" width="7%">Số tiền chưa thuế</th>
            <th scope="col" width="5%">Thuế VAT</th>
            <th scope="col" width="7%">Tổng tiền</th>
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
                    <td><?php echo ($key + 1);?></td>
                    <td><?php echo $value['TEN_DIENLUC'];?></td>
                    <td><?php echo $value['TK_DIENLUC'];?></td>
                    <td><?php echo number_format($value['T_TIENDIEN'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['T_TIENTHUE'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['T_TONGTIEN'], 0, ',', '.');?></td>
                    <td><?php echo $value['NH_DIENLUC'];?></td>
                    <?php
                        $tongchuathue += $value['T_TIENDIEN'];
                        $tongthue += $value['T_TIENTHUE'];
                        $tongtien += $value['T_TONGTIEN'];
                    ?>
                </tr>
            <?php endforeach; ?>
          <tr>
            <td>Tổng</td>
            <td></td>
            <td></td>
            <td><?php echo number_format($tongchuathue, 0, ',', '.');?></td>
            <td><?php echo number_format($tongthue, 0, ',', '.');?></td>
            <td><?php echo number_format($tongtien, 0, ',', '.');?></td>
            <td></td>
          </tr>
        </tbody>
    </table>
    <h4>III. Chi tiết tiền điện theo từng trạm</h4>
    <table>
        <thead>
          <tr>
            <th>Mã khách hàng <br/>trên hóa đơn <br/>điện</th>
            <th>Mã CSHT</th>
            <th>Số tiền <br/>chưa thuế</th>
            <th>Thuế <br/>VAT</th>
            <th>Tổng tiền</th>
            <th>Tổng tiền<br/> đề xuất</th>
            <th>Tên đơn vị hưởng</th>
            <th>Số tài khoản</th>
            <th>Tại ngân hàng</th>
            <th>Mã đơn vị</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($dssddien as $key => $value): ?>
                <tr>
                    <td style="max-width: 110px;word-wrap: all;"><?php echo $value['MA_DIENLUC'];?></td>
                    <td><?php echo $value['MA_CSHT'];?></td>
                    <td><?php echo number_format($value['TIENDIEN'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TIENTHUE'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TONGTIEN'], 0, ',', '.');?></td>
                    <td><?php echo number_format($value['TONGTIEN'], 0, ',', '.');?></td>
                    <td style="max-width: 150px;word-wrap: break-word;"><?php echo $value['TEN_DIENLUC'];?></td>
                    <td><?php echo $value['TK_DIENLUC'];?></td>
                    <td style=""><?php echo $value['NH_DIENLUC'];?></td>
                    <td><?php echo $value['MA_DONVIKT'];?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
