<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
    <?= Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> Danh sách', ['quanlyhocphithutruoc/index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo ngày hết hạn', ['quanlyhocphithutruoc/canhbaotheongay'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo số buổi học', ['quanlyhocphithutruoc/canhbaotheosobuoihoc'], ['class' => 'btn btn-danger btn-flat']) ?>
<?php endif; ?>