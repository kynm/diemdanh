<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Baoduongtong */

$this->title = 'Update Baoduongtong: ' . $model->ID_BDT;
$this->params['breadcrumbs'][] = ['label' => 'Baoduongtongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_BDT, 'url' => ['view', 'id' => $model->ID_BDT]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="baoduongtong-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
