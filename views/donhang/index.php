<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ HỌC PHÍ THU TRƯỚC';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
<?= $this->render('/partial/_header_donhang', []) ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'value' => 'nhanvien.TEN_NHANVIEN',
                            ],
                            [
                                'attribute' => 'ID_DONVI',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Html::a($model->donvi->TEN_DONVI, ['/donvi/view', 'id' => $model->donvi->ID_DONVI]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SO_DT',
                                'value' => 'donvi.SO_DT',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                            ],
                            [
                            'attribute' => 'STATUS',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return statusdonhang()[$model->STATUS];
                                },
                                'filter'=> statusdonhang(),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                            'attribute' => 'TYPE',
                                'contentOptions' => ['style' => 'width:5%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return loaidonhang()[$model->TYPE];
                                },
                                'filter'=> loaidonhang(),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            'SOTIEN',
                            'SO_LOP',
                            'SO_HS',
                            'created_at',
                            'NGAY_BD',
                            'NGAY_KT',
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->GHICHU;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => (Yii::$app->user->can('Administrator')) ? '{update}' : ''
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
