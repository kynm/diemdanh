<?php
use yii\helpers\Html;
?>
<p>
    <?= (Yii::$app->user->can('Administrator')) ? Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    <?= (Yii::$app->user->can('Administrator')) ? Html::a('DS DƠN HÀNG', ['index'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    <?= (Yii::$app->user->can('Administrator')) ? Html::a('Doanh thu', ['doanhthu'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    <?= (Yii::$app->user->can('Administrator')) ? Html::a('Dùng Thử', ['theodoidungthu'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
</p>