<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DANH SÁCH GIA HẠN DỊCH VỤ';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <p>
        <?= Html::a('Danh sách', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Danh sách đang sửa mẫu', ['indextheoketqua', 'ChuanhoamauhoadonSearch[ketqua]' => 1], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Danh sách đã sửa mẫu', ['indextheoketqua', 'ChuanhoamauhoadonSearch[ketqua]' => 2], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Danh sách đã hoàn thành', ['indextheoketqua', 'ChuanhoamauhoadonSearch[ketqua]' => 3], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Danh sách không chỉnh sửa', ['indextheoketqua', 'ChuanhoamauhoadonSearch[ketqua]' => 4], ['class' => 'btn btn-primary btn-flat']) ?>
        <!-- <?= Html::a('Excel', ['excellichsutiepxuc'], ['class' => 'btn btn-primary btn-flat']) ?> -->
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $index, $widget, $grid){
                      return ['style'=>'color:'. colorketqua($model->ketqua) .';'];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                            'buttons' => [
                                'tiepxuckhachhang' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open">Chi tiết</span>', $url, [
                                        'title' => Yii::t('app', 'lead-update'),
                                    ]);
                                },

                            ],
                        ],
                        'TEN_NV',
                        [
                            'attribute' => 'TEN_TB',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'MST',
                        'MA_TB',
                        'ngay_yc',
                        'ngay_sua',
                        'ngay_dong',
                        [
                            'attribute' => 'DIACHI_LD',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'LIENHE',
                        [
                            'attribute' => 'ghichu',
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return $model->ketqua ? ketquasuamau()[$model->ketqua] : 'Chưa liên hệ';
                            }
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>