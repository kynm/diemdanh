<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
    <?= Yii::$app->user->can('diemdanhlophoc') ? Html::a('Danh sách bài kiểm tra', ['chamdiemlophoc', 'idlophoc' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    <?= Yii::$app->user->can('diemdanhlophoc') ? Html::a('Chi tiết điểm', ['chitietchamdiem', 'idlophoc' => $model->ID_LOP], ['class' => 'btn btn-success btn-flat']) : '' ?>
    <?= Yii::$app->user->can('diemdanhlophoc') ? Html::a('Báo cáo', ['baocao', 'idlophoc' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) : '' ?>
<?php endif; ?>
