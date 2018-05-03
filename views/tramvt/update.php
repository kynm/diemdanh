<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Cập nhật trạm ' . $model->MA_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Trạm '.$model->MA_TRAM, 'url' => ['view', 'id' => $model->ID_TRAM]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
