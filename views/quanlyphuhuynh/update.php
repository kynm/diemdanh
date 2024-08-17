<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Cập nhật thông tin phụ huynh';
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="nhanvien-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
