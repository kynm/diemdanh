<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */

$this->title = 'Update Thuchienbd: ' . $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Thuchienbds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DOTBD, 'url' => ['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thuchienbd-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
