<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThietbiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thiết bị';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Thêm thiết bị', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>
<?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'MA_THIETBI',
                    'TEN_THIETBI',
                    [
                        'attribute' => 'ID_NHOMTB',
                        'value' => 'iDNHOMTB.TEN_NHOM'
                    ],
                    'HANGSX',

                    // 'THONGSOKT:ntext',
                    // 'PHUKIEN:ntext',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-thietbi')) ? '{view} {update} {delete}' : '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                $url = Url::to(['thietbi/view', 'id' => $model->ID_THIETBI ]);
                                return Html::a('<span class="fa fa-calendar-check-o"> </span>', $url, ['title' => 'Điều chỉnh nội dung' ]);
                            },
                        ],
                    ]
                ],
            ]); ?>

        </div>
    </div>
</div>