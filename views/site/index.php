<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
    <?php if (Yii::$app->user->can('Administrator')):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number" style="font-size: 20px; color: red;">ĐƠN VỊ</span>
                <?= Html::a($sldonvi, ['/donvi/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number" style="font-size: 20px; color: red;">NHÂN VIÊN</span>
                <?= Html::a($sltk, ['/nhanvien/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number" style="font-size: 20px; color: red;">LỚP HỌC</span>
                <?= $sllh ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number" style="font-size: 20px; color: red;">HỌC SINH</span>
                <?= $slhs ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>