<?php
use yii\helpers\Html;
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
