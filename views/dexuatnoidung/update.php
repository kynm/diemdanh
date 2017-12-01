<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dexuatnoidung */

$this->title = 'Update Dexuatnoidung: ' . $model->ID_LOAITB;
$this->params['breadcrumbs'][] = ['label' => 'Dexuatnoidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_LOAITB, 'url' => ['view', 'ID_LOAITB' => $model->ID_LOAITB, 'LAN_BD' => $model->LAN_BD, 'MA_NOIDUNG' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dexuatnoidung-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
