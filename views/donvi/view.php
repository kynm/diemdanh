<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->MA_DONVI;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_DONVI], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'MA_DONVI',
                    'TEN_DONVI',
                    'DIA_CHI',
                    'SO_DT',
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="col-lg-3 col-6">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
        <div class="info-box-content">
            <span class="info-box-number" style="font-size: 20px; color: red;">NHÂN VIÊN</span>
            <?= $model->getNhanviens()->count() ?>
        </div>
    </div>
</div>
<div class="col-lg-3 col-6">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
        <div class="info-box-content">
            <span class="info-box-number" style="font-size: 20px; color: red;">LỚP HỌC</span>
            <?= $model->getLophoc()->count() ?>
        </div>
    </div>
</div>
<div class="col-lg-3 col-6">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
        <div class="info-box-content">
            <span class="info-box-number" style="font-size: 20px; color: red;">HỌC SINH</span>
            <?= $model->getHocsinh()->count() ?>
        </div>
    </div>
</div>
<p>
    Link: https://diemdanh.online<br>
Tài khoản quản lý: <?= $model->SO_DT?> / <?= $model->SO_DT?> : Dùng để tạo lớp học, tạo học sinh.<br>
Tài khoản điểm danh: <?= $model->SO_DT?>_diemdanh / <?= $model->SO_DT?>_diemdanh<br>
VUI LÒNG ĐỔI MẬT KHẨU ĐỂ SỬ DỤNG!<br>
</p>

