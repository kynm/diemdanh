<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ LỚP';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= (Yii::$app->user->can('create-lophoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm lớp học', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
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
                                'attribute' => 'TEN_LOP',
                                'contentOptions' => ['style' => 'width:40%; white-space: normal;'],
                                'value' => function ($model) {
                                    return Html::a($model->TEN_LOP, ['view', 'id' => $model->ID_LOP]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOHOCSINH',
                                'value' => function ($model) {
                                    return $model->getDshocsinh()->count();
                                }
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
