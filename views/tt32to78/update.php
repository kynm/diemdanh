<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Cập nhật khách hàng:  ' . $model->TEN_KH;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['hoadondientumoi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TEN_KH, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="donvi-update">
    <?= $this->render('_form', [
        'model' => $model,
        // 'dsdonvi' => $dsdonvi,
    ]) ?>
</div>
