<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $listNoiDung,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'MA_NOIDUNG',
        [
            'attribute' => 'NOIDUNG',
            'value' => 'mANOIDUNG.NOIDUNG',
        ],
        'TRANGTHAI',
        'KETQUA',
    ],
]);
Pjax::end();