<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = 'Create Thietbitram';
$this->params['breadcrumbs'][] = ['label' => 'Thietbitrams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
