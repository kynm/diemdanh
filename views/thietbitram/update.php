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

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
