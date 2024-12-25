<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
$this->title = 'CHI TIẾT KIỂM TRA';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('/lophoc/_detail', ['model' => $lophoc,]) ?>
</div>
<?= $this->render('/partial/_chamdiem', ['model' => $lophoc]) ?>
<div class="quanlyhocphi-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'NGAY_CHAMDIEM',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDatetime($model->chamdiem->NGAY_CHAMDIEM, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:20%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->chamdiem->TIEUDE;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'value' => 'hocsinh.HO_TEN',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'filter'=> $dshocsinh,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            'NGHE',
                            'NOI',
                            'DOC',
                            'VIET',
                            'DIEM',
                            [
                                'attribute' => 'NHAN_XET',
                                'contentOptions' => ['style' => 'width:20%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return nl2br($model->NHAN_XET);
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
