<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use kartik\rating\StarRating;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'donvi_id',
            'value' => $model->iDDONVI->TEN_DONVI,
        ],
        [
            'attribute' => 'nhanvien_id',
            'value' => '<strong>' . $model->nHANVIEN->TEN_NHANVIEN . '</strong><a href="tel:' . $model->nHANVIEN->DIEN_THOAI . '">( ' . $model->nHANVIEN->DIEN_THOAI . ' )</a> ' . $model->nHANVIEN->iDDAI->TEN_DAIVT,
            'format' => 'raw',
        ],
        [
            'attribute' => 'nhanvien_xl_id',
            'value' => '<strong>' . $model->nHANVIENXULY->TEN_NHANVIEN . '</strong><a href="tel:' . $model->nHANVIENXULY->DIEN_THOAI . '">( ' . $model->nHANVIENXULY->DIEN_THOAI . ' )</a> ' . $model->nHANVIENXULY->iDDAI->TEN_DAIVT,
            'format' => 'raw',
        ],
        [
            'attribute' => 'status',
            'value' => Html::button(statusbaohong()[$model->status], ['class' => 'btn btn-primary']),
            'format' => 'raw',
        ],
        [
            'attribute' => 'danhgia',
            'value' => in_array($model->status, [4,5]) ? StarRating::widget([ 'name' => 'danhgia', 'value' => $model->danhgia, 'pluginOptions' => [ 'readonly' => true, 'showClear' => false, 'showCaption' => false, ], ]) : '',
            'format' => 'raw',
        ],
        [
            'attribute' => 'dichvu_id',
            'value' => Html::button($model->tendsdichvu, ['class' => 'btn btn-danger']),
            'format' => 'raw',
        ],
        [
            'attribute' => 'ten_kh',
            'value' => '<strong>' . $model->ten_kh . '</strong>',
            'format' => 'raw',
        ],
        [
            'attribute' => 'ma_tb',
            'value' => '<code>' . $model->ma_tb . '</code>',
            'format' => 'raw',
        ],
        [
            'attribute' => 'diachi',
            'value' => '<strong>' . $model->diachi . '</strong>',
            'format' => 'raw',
        ],
        [
            'attribute' => 'so_dt',
            'value' => Html::a($model->so_dt,"tel:".$model->so_dt),
            'format' => 'raw',
        ],
        ['attribute'=>'ngay_bh',
         'value' => $model->ngay_bh,
        ],
        ['attribute'=>'ngay_xl',
         'value' => $model->ngay_xl,

        ],
        'noidung',
        'ghichu',
        [
            'attribute' => 'nguyennhan_id',
            'value' => $model->nguyennhan ? $model->nguyennhan->nguyennhan : '',
        ],
    ],
]) ?>