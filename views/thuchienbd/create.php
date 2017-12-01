<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */

$this->title = 'Create Thuchienbd';
$this->params['breadcrumbs'][] = ['label' => 'Thuchienbds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
