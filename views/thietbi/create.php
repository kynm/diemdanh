<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = 'Thêm thiết bị';
$this->params['breadcrumbs'][] = ['label' => 'Thiết bị', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
