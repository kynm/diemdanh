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
                                'value' => function ($model) {
                                    return $model->lop ? Html::a( $model->lop->TEN_LOP , ['/lophoc/view', 'id' => $model->lop->ID_LOP]) : 'Không xác định';
                                },
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:20%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Html::a($model->TIEUDE, ['view', 'id' => $model->ID]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'created_at',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],

                            [
                                'attribute' => 'SOLUONGHS',
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return $model->lop->getDshocsinh()->andWhere(['STATUS' => 1])->count();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONG',
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->count());
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONGCHUATHU',
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->andWhere(['STATUS' => 0])->count());
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOLUONGDATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->andWhere(['STATUS' => 1])->count());
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIEN',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->sum('TONG_TIEN'));
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIENDATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->andWhere(['STATUS' => 1])->sum('TONG_TIEN'));
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'TONGTIENCHUATHU',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return number_format($model->getChitiethocphi()->andWhere(['STATUS' => 0])->sum('TONG_TIEN'));
                                },
                                'format' => 'raw',
                            ],
                            'TU_NGAY',
                            'DEN_NGAY',
                            [
                                'attribute' => '',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    $text = Html::a('<i class="fa fa-file-pdf-o"></i> Export Pdf', ['/quanlyhocphi/exportpdf', 'id' => $model->ID], ['class' => 'btn btn-success btn-flat', 'target' => '_blank', 'data-pjax' => 0]) . '<br/>';
                                    if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && !$model->getChitiethocphi()->where(['STATUS' => 1])->count()) {
                                        $text .= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                                            'class' => 'btn btn-danger btn-flat',
                                            'data' => [
                                                'confirm' => 'Dữ liệu sẽ biến mất hoàn toàn. Bạn chắc chắn muốn xóa mục này?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }

                                    return $text;
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
