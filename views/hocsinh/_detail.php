<?php
use yii\helpers\Html;
?>
<div class="box box-primary">
    <?php if ( !$model->getDshocphi()->count()  && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI):?>
        <p>
            <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                'class' => 'btn btn-danger btn-flat pull-right',
                'data' => [
                    'confirm' => 'Hành động này sẽ xóa vĩnh viên học sinh và các thông tin liên quan.Bạn chắc chắn muốn xóa học sinh này?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif;?>
    <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?= $model->HO_TEN ?></h3>
        <p class="text-muted text-center"><?= $model->lop->TEN_LOP?></p>
        <p class="text-muted text-center">Giáo viên: <?= $model->lop->nhanviendiemdanh->TEN_NHANVIEN?></p>
        <ul class="list-group list-group-unbordered">
        <a href="#" class="btn btn-primary btn-block"><b><?= $model->trangthai->TRANGTHAI?></b></a>
        </ul>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
    <hr>
    <strong><i class="fa fa-map-marker margin-r-5"></i> Địa chỉ</strong>
    <p class="text-muted"><?= $model->DIA_CHI?></p>
    </div>
</div>