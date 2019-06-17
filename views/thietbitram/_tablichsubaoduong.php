<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use app\models\Noidungcongviec;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $lsbaoduongProvider,
    // 'filterModel' => $searchModel,
    // 'pjax' => true,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['style' => 'width:50px'],
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                $query = Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $_GET['id']]);
                $listNoiDung = new ActiveDataProvider([
                    'query' => $query,
                ]);
                return Yii::$app->controller->renderPartial('_expand-row-details', ['listNoiDung' => $listNoiDung]);
            },
            'expandOneOnly' => true,
            'headerOptions' => ['display' => 'none']
        ],
        [
            'attribute' => 'ID_DOTBD',
            'value' => 'MA_DOTBD',
        ],
        [
            'attribute' => 'NGAY_BD',
            'value' => 'NGAY_BD'
        ],
        [
            'attribute' => 'NGAY_KT',
            'value' => 'NGAY_KT'
        ],
        [
            'attribute' => 'TRANGTHAI',
            'value' => function ($model) {
                switch ($model->TRANGTHAI) {
                    case 'dangthuchien':
                        return 'Đang thực hiện';
                    case 'ketthuc':
                        return 'Đã kết thúc';
                    
                    default:
                        return 'Kế hoạch';
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Yii::$app->user->can('create-tramvt') ? '{view} {update} {delete}' : '{view}',
        ],
    ],
]);
Pjax::end();