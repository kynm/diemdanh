<?php
use yii\helpers\Html;
?>
    <li>
        <?= Html::a('Lịch sử điểm danh', ['chitiethocsinh', 'mahs' => $model->MA_HOCSINH], ['class' => 'btn btn-primary btn-flat']) ?>
    </li>
    <li>
        <?= Html::a('Học phí', ['hocphitheothang', 'mahs' => $model->MA_HOCSINH], ['class' => 'btn btn-primary btn-flat']) ?>
    </li>
