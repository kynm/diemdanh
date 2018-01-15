<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Cập nhật đơn vị: ' . $model->MA_DONVI;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MA_DONVI, 'url' => ['view', 'id' => $model->ID_DONVI]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="donvi-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
