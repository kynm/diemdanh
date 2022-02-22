<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Thêm báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Báo hỏng', 'url' => ['baohong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baohong-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dsNhanvien' => $dsNhanvien,
    ]) ?>

</div>
