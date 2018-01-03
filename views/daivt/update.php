<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Update Daivt: ' . $model->ID_DAI;
$this->params['breadcrumbs'][] = ['label' => 'Daivts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DAI, 'url' => ['view', 'id' => $model->ID_DAI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="daivt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
