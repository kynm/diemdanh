<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Cập nhật đài ' . $model->MA_DAIVT;
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MA_DAIVT, 'url' => ['view', 'id' => $model->ID_DAI]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="daivt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
