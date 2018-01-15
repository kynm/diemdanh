<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Cập nhật đợt bảo dưỡng ' . $model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MA_DOTBD, 'url' => ['view', 'id' => $model->ID_DOTBD]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="dotbaoduong-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
