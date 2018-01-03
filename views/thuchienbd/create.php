<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */

$this->title = 'Create Thuchienbd';
$this->params['breadcrumbs'][] = ['label' => 'Thuchienbds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
