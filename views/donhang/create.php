<?php
use yii\helpers\Html;
$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dsdonvi' => $dsdonvi,
    ]) ?>
</div>