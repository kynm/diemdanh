<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?= $model->HO_TEN ?></h3>
        <p class="text-muted text-center"><?= $model->lop->TEN_LOP?></p>
        <p class="text-muted text-center">Giáo viên: <?= $model->lop->nhanviendiemdanh->TEN_NHANVIEN?></p>
        <ul class="list-group list-group-unbordered">
        <span  class="btn btn-primary btn-block"><b><?= $model->trangthai->TRANGTHAI?></b></span>
        </ul>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
    <hr>
    <strong><i class="fa fa-map-marker margin-r-5"></i> Địa chỉ: <?= $model->DIA_CHI?></strong>
    </div>
</div>