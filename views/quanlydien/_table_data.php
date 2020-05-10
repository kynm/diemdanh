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
                <h4>I   Chi tiết tiền điện theo từng trạm</h4>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã khách hàng trên hóa đơn điện</th>
                        <th scope="col">Mã CSHT</th>
                        <th scope="col">Số tiền chưa thuế</th>
                        <th scope="col">Thuế VAT</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Tên đơn vị hưởng</th>
                        <th scope="col">Số tài khoản</th>
                        <th scope="col">Tại ngân hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dssddien as $key => $value): ?>
                            <tr>
                                <th scope="col"><?php echo ($key + 1);?></th>
                                <th scope="col"><?php echo $value['MA_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['MA_CSHT'];?></th>
                                <th scope="col"><?php echo $value['TIENDIEN'];?></th>
                                <th scope="col"><?php echo $value['TIENTHUE'];?></th>
                                <th scope="col"><?php echo $value['TONGTIEN'];?></th>
                                <th scope="col"><?php echo $value['TONGTIEN'];?></th>
                                <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['NH_DIENLUC'];?></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h4>II   Số tiền thanh toán theo từng tài khoản cụ thể như sau: </h4>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên đơn vị hưởng</th>
                        <th scope="col">Số tài khoản</th>
                        <th scope="col">Số tiền chưa thuế</th>
                        <th scope="col">Thuế VAT</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Tên đơn vị hưởng</th>
                        <th scope="col">Số tài khoản</th>
                        <th scope="col">Tại ngân hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tongdien as $key => $value): ?>
                            <tr>
                                <th scope="col"><?php echo ($key + 1);?></th>
                                <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['T_TIENDIEN'];?></th>
                                <th scope="col"><?php echo $value['T_TIENTHUE'];?></th>
                                <th scope="col"><?php echo $value['T_TONGTIEN'];?></th>
                                <th scope="col"><?php echo $value['TEN_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['TK_DIENLUC'];?></th>
                                <th scope="col"><?php echo $value['NH_DIENLUC'];?></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>