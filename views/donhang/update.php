<?php
$this->title = 'Cập nhật đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dsdonvi' => $dsdonvi,
    ]) ?>
</div>
