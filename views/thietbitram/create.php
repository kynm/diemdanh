<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = 'Thêm thiết bị trạm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['tramvt/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
