<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Cập nhật thông tin học sinh';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HO_TEN, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="nhanvien-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dslop' =>$dslop,
    ]) ?>
</div>
