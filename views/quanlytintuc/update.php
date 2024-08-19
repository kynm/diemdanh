<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'CẬP NHẬT';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
