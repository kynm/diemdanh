<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Thông tin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_detail_hocsinh', ['model' => $model,]) ?>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?= $this->render('_header_thongtinhocsinh', ['model' => $model,]) ?>
            </ul>
            <div class="tab-content">
                <div class="table-responsive">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($model) {
                                    return date("d/m/Y",  strtotime($model->created_at));
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:30%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->hocphi->TIEUDE;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_LOP',
                                'value' => 'hocphi.lop.TEN_LOP',
                            ],
                            'TONG_TIEN',
                            [
                                'attribute' => 'STATUS',
                                'value' => function ($model) {
                                    return $model->STATUS ? '<span class="btn btn-flat btn-success">Đã thu</span>' : '<span class="btn btn-flat btn-danger">Chưa thu</span>';
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
</div>