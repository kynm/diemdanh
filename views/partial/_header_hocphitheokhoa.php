<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
    <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tạo mới', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i>DS HỌC PHÍ', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> CHI TIẾT THU HỌC PHÍ', ['chitietthuhocphidonvi'], ['class' => 'btn btn-success btn-flat']) ?>
<?php endif; ?>