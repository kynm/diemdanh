<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
    <?= Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> Danh sách', ['quanlyhocphithutruoc/index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?php if (Yii::$app->user->can('hocphithutruoctheobuoi')):?>
        <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo buổi học', ['quanlyhocphithutruoc/canhbaotheosobuoihoc'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?php elseif(Yii::$app->user->can('chihocphithutruoctheothoigian')): ?>
        <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo ngày', ['quanlyhocphithutruoc/canhbaotheongay'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?php else: ?>
        <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo buổi học', ['quanlyhocphithutruoc/canhbaotheosobuoihoc'], ['class' => 'btn btn-danger btn-flat']) ?>
        <?= Html::a('<i class="fa fa-list"></i> Cảnh báo theo ngày', ['quanlyhocphithutruoc/canhbaotheongay'], ['class' => 'btn btn-danger btn-flat']) ?>
    <?php endif; ?>
    <?= Html::a('Báo cáo thu tiền', ['quanlyhocphithutruoc/baocaohocphithutruoc'], ['class' => 'btn btn-primary btn-flat']) ?>
<?php endif; ?>