<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Nhật ký sử dụng máy nổ ' . $thietbitram->iDLOAITB->TEN_THIETBI . ' Tại trạm ' . $thietbitram->iDTRAM->TEN_TRAM;
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">
    <?= $this->render('_form', [
        'model' => $model,
        'thietbitram' => $thietbitram,
    ]) ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'USER_ID',
                            'value' => 'nGUOITAO.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ID_NV_VANHANH',
                            'value' => 'nHANVIENVANHANH.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ID_TRAM',
                            'value' => 'tRAMVANHANH.TEN_TRAM'
                        ],
                        [
                            'attribute' => 'THOIGIANBATDAU',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        [
                            'attribute' => 'THOIGIANKETTHUC',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        'DINHMUC',
                        [
                            'attribute' => 'hous',
                        ],
                        [
                            'attribute' => 'soluong',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url,$model) {
                                    if (!$model->IS_CHECKED) {
                                        $url = Url::to(['quanlymayno/updatenhatky', 'id' => $model->ID]);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"> </span>', $url, ['title' => 'Điều chỉnh nội dung' ]);
                                    }

                                    return '';
                                },
                                'delete' => function ($url,$model,$key) {
                                    if (!$model->IS_CHECKED) {
                                        $url = Url::to(['quanlymayno/deletenhatky', 'id' => $model->ID]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['quanlymayno/deletenhatky', 'id' => $model->ID], [
                                            'class' => '',
                                            'data' => [
                                                'confirm' => 'Bạn có chắc chắn muốn xóa dữ liệu không?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                        return '';
                                },
                            ],
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>