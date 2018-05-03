<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Thêm đơn vị';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
