<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Cập nhật nội dung ' . $model->MA_NOIDUNG;
$this->params['breadcrumbs'][] = ['label' => 'Nội dung bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MA_NOIDUNG, 'url' => ['view', 'id' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="noidungbaotri-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
