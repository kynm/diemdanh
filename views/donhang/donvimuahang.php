<?php
$this->title = 'BẢNG GIÁ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">
    <?= $this->render('_form_donvimuahang', [
        'model' => $model,
    ]) ?>
</div>
