<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Update Noidungbaotri: ' . $model->MA_NOIDUNG;
$this->params['breadcrumbs'][] = ['label' => 'Noidungbaotris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MA_NOIDUNG, 'url' => ['view', 'id' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="noidungbaotri-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
