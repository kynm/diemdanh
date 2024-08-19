<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
<li class="">
    <?= Yii::$app->user->can('quanlyhocsinh') ? Html::a('Lịch sử điểm danh', ['lichsudiemdanh', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) : '' ?>
</li>
<li class="">
    <?= Yii::$app->user->can('quanlytruonghoc') ? Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) : '' ?>
</li>
    <?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HPTT):?>
<li class="">
    <?= Html::a('</i> THU HỌC PHÍ (THEO THÁNG)', ['/hocsinh/hocphitheothang', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) ?>
</li>
<?php endif; ?>
<?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HP_T):?>
<li class="">
    <?= Html::a('</i> HỌC PHÍ THU TRƯỚC', ['/hocsinh/hocphithutruoc', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) ?>
</li>
<?php endif; ?>
<?php endif; ?>
