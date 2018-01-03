<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Update Dotbaoduong: ' . $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Dotbaoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DOTBD, 'url' => ['view', 'id' => $model->ID_DOTBD]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dotbaoduong-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
