<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = 'Cập nhật thiết bị ' . $model->iDLOAITB->TEN_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['tramvt/index']];
$this->params['breadcrumbs'][] = ['label' => 'Trạm '.$model->iDTRAM->TEN_TRAM, 'url' => ['tramvt/view', 'id' => $model->ID_TRAM]];
$this->params['breadcrumbs'][] = ['label' => $model->iDLOAITB->TEN_THIETBI, 'url' => ['view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="thietbitram-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
