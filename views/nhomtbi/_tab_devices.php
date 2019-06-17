<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>
<p>
    <?= (Yii::$app->user->can('create-loaitb')) ? Html::a('<i class="fa fa-plus"></i> Thêm loại thiết bị', ['thietbi/create', 'id' => $model->ID_NHOM], ['class' => 'btn btn-primary btn-flat']) : '' ?>
</p>    
<div class="table-responsive">
    <?= GridView::widget([
            'dataProvider' => $devicesProvider,
            'filterModel' => $devicesSearchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'MA_THIETBI',
                'TEN_THIETBI',
                'HANGSX',

                'THONGSOKT:ntext',
                // 'PHUKIEN:ntext',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => (Yii::$app->user->can('edit-loaitb')) ? '{view} {update} {delete}' : '{view}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['thietbi/view', 'id' => $model->ID_THIETBI]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['thietbi/update', 'id' => $model->ID_THIETBI]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['thietbi/delete', 'id' => $model->ID_THIETBI]);
                            return $url;
                        }
                    },
                    // 'buttons' => [
                    //     'view' => function ($url, $model) {
                    //         return Html::a('<span class="fa fa-calendar-check-o"> </span>', $url, ['title' => 'Điều chỉnh nội dung' ]);
                    //     },
                    // ],
                ],
            ],
        ]); ?>
</div>