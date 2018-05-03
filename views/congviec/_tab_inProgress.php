<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin(['method' => 'get', 'action' => Url::to(['congviec/index'])]);

echo '<p><div class="col-sm-2">'
    .Html::dropDownList('action', NULL,
        [
            1 => 'Hoàn thành',
            2 => 'Chưa hoàn thành'
        ], 
        [
            // 'prompt' => 'Chọn hành động',
            'class' => 'form-control'
        ]).
    '</div>'
    .Html::submitButton(
        '<i class="glyphicon glyphicon-play"></i> Thực hiện', 
        [
            'class'=>'btn btn-primary btn-flat',
        ]).'</p>'; 

Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $inprogressProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->TRANGTHAI == 'Hoàn thành') {
                return ['class' => 'success'];
            }
        },
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
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
ActiveForm::end();
?>