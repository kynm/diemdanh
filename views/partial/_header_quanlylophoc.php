<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlytruonghoc')):?>
    <?= (Yii::$app->user->can('create-lophoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm lớp học', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    <?= (Yii::$app->user->can('create-lophoc')) ? Html::a('<i class="fa fa-file-excel-o"></i> Export', ['export'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
<?php endif; ?>