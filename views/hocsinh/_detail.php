<?php
use yii\widgets\DetailView;
?>
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?= $model->HO_TEN ?></h3>
        <p class="text-muted text-center"><?= $model->lop->TEN_LOP?></p>
        <ul class="list-group list-group-unbordered">
        </ul>
        <a href="#" class="btn btn-primary btn-block"><b><?= $model->trangthai->TRANGTHAI?></b></a>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
    <hr>
    <strong><i class="fa fa-map-marker margin-r-5"></i> Địa chỉ</strong>
    <p class="text-muted"><?= $model->DIA_CHI?></p>
    </div>
</div>