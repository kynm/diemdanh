<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $lsbaoduongProvider,
    // 'filterModel' => $searchModel,
    // 'pjax' => true,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ID_DOTBD',
            'value' => 'dOTBD.MA_DOTBD',
        ],
        [
            'attribute' => 'MA_NOIDUNG',
            'value' => 'mANOIDUNG.NOIDUNG'
        ],
        'TRANGTHAI',
        'KETQUA',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Yii::$app->user->can('create-tramvt') ? '{view} {update} {delete}' : '{view}',
        ],
    ],
]);
Pjax::end();