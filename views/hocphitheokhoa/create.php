<?php
$this->title = 'Tạo mới';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/partial/_header_hocphitheokhoa', []) ?>
<div class="daivt-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dslop' => $dslop,
    ]) ?>
</div>
