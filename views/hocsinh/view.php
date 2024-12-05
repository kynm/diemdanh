<?php
$this->title = 'Thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_detail', ['model' => $model,]) ?>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?= $this->render('/partial/_header_hocsinh', ['model' => $model,]) ?>
            </ul>
            <div class="tab-content">
            </div>
        </div>
    </div>
</div>