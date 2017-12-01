<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Update Donvi: ' . $model->ID_DONVI;
$this->params['breadcrumbs'][] = ['label' => 'Donvis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DONVI, 'url' => ['view', 'id' => $model->ID_DONVI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="donvi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
