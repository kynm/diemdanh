<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Create Noidungbaotri';
$this->params['breadcrumbs'][] = ['label' => 'Noidungbaotris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
