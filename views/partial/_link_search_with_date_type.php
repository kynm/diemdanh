<?php
use yii\helpers\Html;
?>
<div class="col-md-12">
    <div class="box-footer">
        <div class="text-center">
            <?= Html::a('Tháng trước', ['/' . $url . '?type=3' ], ['class' => $type == 3 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Tuần trước', ['/' . $url . '?type=2'], ['class' => $type == 2 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Hôm qua', ['/' . $url . '?type=1'], ['class' => $type == 1 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Hôm nay', ['/' . $url . '?type=0'], ['class' => $type == 0 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Tuần hiện tại', ['/' . $url . '?type=5'], ['class' => $type == 5 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Tháng hiện tại', ['' . $url . '/?type=6'], ['class' => $type == 6 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
            <?= Html::a('Năm hiện tại', ['/' . $url . '?type=8'], ['class' => $type == 8 ? 'btn btn-danger btn-flat active' : 'btn btn-danger btn-flat']) ?>
        </div>
    </div>
</div>