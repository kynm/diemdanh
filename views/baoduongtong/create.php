<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Baoduongtong */

$this->title = 'Create Baoduongtong';
$this->params['breadcrumbs'][] = ['label' => 'Baoduongtongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baoduongtong-create" id="baoduongtong-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
