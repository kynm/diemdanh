<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = 'Update Thietbitram: ' . $model->ID_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Thietbitrams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_THIETBI, 'url' => ['view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thietbitram-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
