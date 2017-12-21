<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Thuchienbd;
use app\models\Dotbaoduong;

/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Ketquas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ketqua-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ketqua-form">
    <?php $form = ActiveForm::begin(); ?>
        <p class="form-inline">
            <div class="form-group col-md-3 col-sm-6">
                <label>Trạm viễn thông</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->iDTRAMVT->MA_TRAM ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Ngày bảo dưỡng</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->NGAY_BD ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Nhóm trưởng</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->tRUONGNHOM->TEN_NHANVIEN ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Trạng thái</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->TRANGTHAI ; ?>">
            </div>
            <div class="form-group col-md-12">
                <label>Kết quả</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->KETQUA ; ?>">
            </div>
            <div class="form-group col-md-12">
                <label>Ghi chú</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->GHICHU ; ?>">
            </div>
        </p>
        <div class="row col-md-12">
            <div class="col-xs-6 col-md-4">
                <a href="#" class="thumbnail">
                  <img src="<?= $model->ANH1 ; ?>" alt="Anh 1">
                </a>
            </div>
            <div class="col-xs-6 col-md-4">
                <a href="#" class="thumbnail">
                  <img src="<?= $model->ANH2 ; ?>" alt="Anh 2">
                </a>
            </div>
            <div class="col-xs-6 col-md-4">
                <a href="#" class="thumbnail">
                  <img src="<?= $model->ANH3 ; ?>" alt="Anh 3">
                </a>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    </div>


</div>
