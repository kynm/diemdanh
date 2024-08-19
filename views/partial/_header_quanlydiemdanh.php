<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('quanlytruonghoc')):?>
    <?= Html::a('<i class="fa fa-list"></i>DS ĐIỂM DANH', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Yii::$app->user->can('theodoihocbu') ? Html::a('<i class="fa fa-list"></i> THEO DÕI HỌC BÙ', ['theodoihocbu'], ['class' => 'btn btn-success btn-flat'])  : ''?>
<?php endif; ?>