<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = 'Cập nhật thiết bị: ' . $model->TEN_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Thiết bị', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TEN_THIETBI, 'url' => ['view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="thietbi-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
