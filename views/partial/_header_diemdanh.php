<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
    <?= Yii::$app->user->can('diemdanhlophoc') ? Html::a('Timeline', ['/lophoc/quanlydiemdanh', 'id' => $model->ID_LOP], ['class' => 'btn btn-success btn-flat']) : '' ?>
    <?= Yii::$app->user->can('diemdanhlophoc') ? Html::a('Bảng tổng hợp', ['/lophoc/quanlydiemdanhnew', 'id' => $model->ID_LOP], ['class' => 'btn btn-success btn-flat']) : '' ?>
<?php endif; ?>
