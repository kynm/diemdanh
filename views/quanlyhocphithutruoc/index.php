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
    <p>
        <?= (Yii::$app->user->can('quanlytruonghoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'ID_LOP',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;'],
                                'value' => 'lop.TEN_LOP',
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;'],
                                'value' => function ($model) {
                                    return $model->hocsinh->HO_TEN;
                                },
                            ],
                            'created_at',
                            'SOTIEN',
                            'SO_BH',
                            'NGAY_BD',
                            'NGAY_KT',
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;'],
                                'value' => function($model) {
                                    return $model->GHICHU;
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
