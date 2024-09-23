<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
    <?= Html::a('<i class="fa fa-list"></i>DS LỊCH HỌC CỐ ĐỊNH', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a('BẢNG LỊCH HỌC CỐ ĐỊNH', ['chitietbanglichhoccodinh'], ['class' => 'btn btn-success btn-flat']) ?>
<?php endif; ?>