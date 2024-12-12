<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocphi')):?>
    <?php if (Yii::$app->user->can('taohocphitoantrungtam')):?>
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tạo mới toàn trung tâm', ['createmultiple'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?php endif; ?>
    <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tạo mới', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i>DS HỌC PHÍ', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('<i class="fa fa-list"></i> CHI TIẾT THU HỌC PHÍ', ['chitietthuhocphidonvi'], ['class' => 'btn btn-success btn-flat']) ?>
<?php endif; ?>