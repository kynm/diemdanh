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
<li class="">
    <?= Yii::$app->user->can('quanlytruonghoc') ? Html::a('</i> HỌC PHÍ', ['view', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) : '' ?>
</li>
<?php endif; ?>
