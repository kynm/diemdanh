<?php
use yii\helpers\Html;
?>
<div class="col-md-12">
    <div class="text-center">
        <?= Html::a('Chi tiết lớp', ['/lophoc/view', 'id' => $model->ID_LOP ], ['class' => 'btn btn-primary']) ?>
    </div>
</div>