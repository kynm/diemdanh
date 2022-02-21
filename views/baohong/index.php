<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('create-baohong')) ? Html::a('<i class="fa fa-plus"></i> Báo hỏng', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    // 'formatter' => [
                    //     'class' => 'yii\i18n\Formatter',
                    //     'nullDisplay' => '',
                    // ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'donvi_id',
                            'value' => 'iDDONVI.TEN_DONVI'
                        ],
                        [
                            'attribute' => 'dai_id',
                            'value' => 'iDDAI.TEN_DAIVT'
                        ],
                        
                        'ten_kh',
                        'diachi',
                        'so_dt',
                        'ngay_bh',
                        'ngay_xl',
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {xulybaohong}',
                            'buttons' => [
                                'xulybaohong' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                'title' => Yii::t('app', 'lead-update'),
                                    ]);
                                },

                            ],
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>