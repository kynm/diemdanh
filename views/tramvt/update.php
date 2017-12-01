<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Update Tramvt: ' . $model->ID_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Tramvts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_TRAM, 'url' => ['view', 'id' => $model->ID_TRAM]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tramvt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
