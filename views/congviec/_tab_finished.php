<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $finishedProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->KETQUA == 'Chưa đạt') {
                return ['class' => 'danger'];
            }
        },
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ID_THIETBI',
                'value' => 'tHIETBI.iDLOAITB.TEN_THIETBI'
            ],
            [
                'attribute' => 'MA_NOIDUNG',
                'value' => 'mANOIDUNG.NOIDUNG'
            ],
            [
                'attribute' => 'ID_DOTBD',
                'value' => 'dOTBD.MA_DOTBD',
            ],
            'TRANGTHAI',
            // [
            //     'attribute' => 'Trạng thái',
            //     'value' => 'dOTBD.TRANGTHAI'
            // ],
            'KETQUA',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return ($model->dOTBD->TRANGTHAI == 'Đang thực hiện') ?  Html::a('<span class="glyphicon glyphicon-pencil"> </span>', $url) : '';
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Url::to(['congviec/view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]);
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Url::to(['congviec/update', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]);
                        return $url;
                    }
                }
            ],
        ],
    ]);
Pjax::end();
?>