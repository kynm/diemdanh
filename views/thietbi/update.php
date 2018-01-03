<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = 'Update Thietbi: ' . $model->ID_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Thietbis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_THIETBI, 'url' => ['view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thietbi-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
