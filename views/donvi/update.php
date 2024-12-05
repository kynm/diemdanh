<?php
$this->title = 'Cập nhật đơn vị: ' . $model->MA_DONVI;
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="donvi-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
