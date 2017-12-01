<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Thêm đợt bảo dưỡng';
$this->params['breadcrumbs'][] = ['label' => 'Dotbaoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
