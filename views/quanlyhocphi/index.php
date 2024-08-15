<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Quản lý học phí';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý học phí', 'url' => ['quanlyhocphi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/partial/_header_quanlyhocphi', []) ?>
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
                                'attribute' => 'ID_LOP',
                                'value' => 'lop.TEN_LOP',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:30%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Html::a($model->TIEUDE, ['view', 'id' => $model->ID]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONG',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->count();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONGCHUATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->andWhere(['STATUS' => 0])->count();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONGDATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->andWhere(['STATUS' => 1])->count();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIEN',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->sum('TONG_TIEN');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIENDATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->andWhere(['STATUS' => 1])->sum('TONG_TIEN');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIENCHUATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->getChitiethocphi()->andWhere(['STATUS' => 0])->sum('TONG_TIEN');
                                },
                                'format' => 'raw',
                            ],
                            'TU_NGAY',
                            'DEN_NGAY',
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
