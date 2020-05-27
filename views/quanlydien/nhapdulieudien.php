<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'NHập dữ liệu điện tại trạm ' . $tramvt->TEN_TRAM . $tramvt->MA_TRAM;
?>
<div class="tramvt-update">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'NAM',
                        'THANG',
                        'TIENDIEN',
                        'TIENTHUE',
                        'TONGTIEN',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '',
                            // 'template' => '{update} {delete}',
                            // 'buttons' => [
                            //     'update' => function ($url,$model) {
                            //         $url = Url::to(['quanlydien/update', 'id' => $model->ID]);
                            //         return Html::a('<span class="glyphicon glyphicon-pencil"> </span>', $url, ['title' => 'Điều chỉnh nội dung' ]);
                            //     },
                            //     'delete' => function ($url,$model,$key) {
                            //         $url = Url::to(['quanlydien/delete', 'id' => $model->ID]);
                            //         return Html::a('<span class="glyphicon glyphicon-trash"> </span>', $url, ['title' => 'Xóa' ]);
                            //     },
                            // ],
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
</div>