<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
// $this->title = 'NHập hợp dồng ' . $tramvt->TEN_TRAM . $tramvt->MA_TRAM;
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="hopdong-update">
    <div class="box box-primary">
        <div class="box-body">
            fsdfsfsf
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_HOPDONG',
                        'TEN_HOPDONG',
                        'NGAYKY',
                        'NGAY_BD',
                        'NGAYKT',
                        'TEN_VT',
                        'DIACHI',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '',
                            'template' => '{update}',
                            // 'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url,$model) {
                                    $url = Url::to(['quanlyhopdong/xemphieuthu', 'id' => $model->ID]);
                                    return Html::a('<span class="btn btn-default btn-success">Xem phiếu thu </span>', $url, ['title' => 'Tạo phiếu thu' ]);
                                },
                                // 'delete' => function ($url,$model,$key) {
                                //     $url = Url::to(['quanlydien/delete', 'id' => $model->ID]);
                                //     return Html::a('<span class="glyphicon glyphicon-trash"> </span>', $url, ['title' => 'Xóa' ]);
                                // },
                            ],
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>