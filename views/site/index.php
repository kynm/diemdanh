<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'TRANG CHỦ';
?>
<div class="row">
    <?php if (1): ?>
    <div class="col-md-3">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active"  style="background-color: #de4d88  !important;">
                <a href="/giahandichvu/index"><h3 class="widget-user-username" style="text-align: center;color: white;">KHẢO SÁT DOANH NGHIỆP, KẾ TOÁN</h3></a>
            </div>
            <div class="widget-user-image">
            <img class="img-circle" src="/dist/img/1_ava.png" alt="thamcanhdichvu">
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 border-right">
                        <div class="description-block">
                        <span class="description-header"><?= Html::a('KHÁCH HÀNG', ['/giahandichvu/index'], ['class' => 'btn btn-primary btn-flat'])?></span>
                            <span class="description-header"><?= Html::a('BÁO CÁO', ['/giahandichvu/dashboard'], ['class' => 'btn btn-primary btn-flat'])?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (1): ?>
    <div class="col-md-3">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active"  style="background-color: #de4d88  !important;">
                <a href="/chuanhoamauhoadon/index"><h3 class="widget-user-username" style="text-align: center;color: white;">CHUẨN HÓA MẪU HÓA ĐƠN</h3></a>
            </div>
            <div class="widget-user-image">
            <img class="img-circle" src="/dist/img/1_ava.png" alt="thamcanhdichvu">
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 border-right">
                        <div class="description-block">
                        <span class="description-header"><?= Html::a('KHÁCH HÀNG', ['/chuanhoamauhoadon/index'], ['class' => 'btn btn-primary btn-flat'])?></span>
                            <span class="description-header"><?= Html::a('BÁO CÁO', ['/chuanhoamauhoadon/dashboard'], ['class' => 'btn btn-primary btn-flat'])?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (false): ?>
    <div class="col-md-3">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active"  style="background-color: #de4d88  !important;">
                <a href="/thamcanhdichvu/index"><h3 class="widget-user-username" style="text-align: center;color: white;">THÂM CANH DỊCH VỤ</h3></a>
            </div>
            <div class="widget-user-image">
            <img class="img-circle" src="/dist/img/1_ava.png" alt="thamcanhdichvu">
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 border-right">
                        <div class="description-block">
                        <span class="description-header"><?= Html::a('KHÁCH HÀNG', ['/thamcanhdichvu/index'], ['class' => 'btn btn-primary btn-flat'])?></span>
                        <span class="description-header"><?= Html::a('LỊCH SỬ', ['/thamcanhdichvu/lichsutiepxuc'], ['class' => 'btn btn-primary btn-flat'])?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>