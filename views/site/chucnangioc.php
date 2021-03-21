<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['ioc/phanbothuebao']) ?>">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-google-plus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Phân bố thuê bao</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsachvieccanxacnhan']) ?>">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Xác nhận tổ trưởng</span>
                    <span class="info-box-number"></span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/lichsu']) ?>">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Lịch sử hoàn thành</span>
                    <span class="info-box-number">760</span>
                </div>
            </div>
        </a>
    </div>
</div>