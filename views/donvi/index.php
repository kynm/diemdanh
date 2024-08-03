<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DonviSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đơn vị chủ quản';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-index">
    <p>
        <?= (Yii::$app->user->can('create-donvi')) ? Html::a('<i class="fa fa-plus"></i> Thêm đơn vị', ['create'], ['class' => 'btn btn-primary btn-flat']) : ''?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $index, $widget, $grid){
                      return ['style'=>'color:'. colorstatusdonvi($model->STATUS) .' !important;'];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'TEN_DONVI',
                            'value' => function ($model) {
                                return (Yii::$app->user->can('edit-donvi')) ? Html::a($model->TEN_DONVI, ['view', 'id' => $model->ID_DONVI]) : $model->TEN_DONVI;
                            },
                            'contentOptions' => ['style' => 'width:20%;white-space: normal;word-break: break-word;word-break: break-word;'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'STATUS',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                            'value' => function ($model) {
                                return statusdonvi()[$model->STATUS];
                            },
                            'filter'=> statusdonvi(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                        ],
                        'SO_DT',
                        [
                            'attribute' => 'NHANVIEN',
                            'value' => function ($model) {
                                return $model->getNhanviens()->count();
                            },
                        ],
                        [
                            'attribute' => 'LOP',
                            'value' => function ($model) {
                                return $model->getLophoc()->andWhere(['STATUS' => 1])->count();
                            },
                        ],
                        'SO_LOP',
                        [
                            'attribute' => 'HOCSINH',
                            'value' => function ($model) {
                                return $model->getHocsinh()->andWhere(['STATUS' => 1])->count();
                            },
                        ],
                        [
                            'attribute' => 'LUOTDIEMDANH',
                            'value' => function ($model) {
                                return $model->getDsdiemdanh()->count();
                            },
                        ],
                        'SO_HS',
                        'NGAY_BD',
                        'NGAY_KT',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>
