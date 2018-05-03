<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungcongviec */

$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => 'Công việc', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DOTBD, 'url' => ['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="noidungcongviec-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
