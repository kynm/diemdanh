<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

$this->title = 'Cập nhật ' . $model->TEN_NHOM;
$this->params['breadcrumbs'][] = ['label' => $model->TEN_NHOM, 'url' => ['view', 'id' => $model->ID_NHOM]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nhomtbi-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
