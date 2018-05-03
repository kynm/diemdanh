<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Cập nhật nội dung ' . $model->MA_NOIDUNG;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhóm thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDTHIETBI->iDNHOMTB->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $model->iDTHIETBI->ID_NHOMTB]];
$this->params['breadcrumbs'][] = ['label' => $model->iDTHIETBI->TEN_THIETBI, 'url' => ['thietbi/view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = ['label' => 'Mã '.$model->MA_NOIDUNG, 'url' => ['view', 'id' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="noidungbaotri-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
