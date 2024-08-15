<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Cập nhật lớp ' . $model->TEN_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->TEN_LOP, 'url' => ['view', 'id' => $model->ID_LOP]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="daivt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
