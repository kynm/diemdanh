<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\hocsinh */

$this->title = 'Thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_detail', ['model' => $model,]) ?>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?= $this->render('/partial/_header_hocsinh', ['model' => $model,]) ?>
            </ul>
            <div class="tab-content">
                <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'STATUS',
                                'value' => function ($model) {
                                    return $model->STATUS ? '<span class="btn btn-flat btn-success">Đã thu</span>' : '<span class="btn btn-flat btn-danger">Chưa thu</span>';
                                },
                                'format' => 'raw',
                            ],
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
                                    return $model->TIEUDE;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_LOP',
                                'value' => 'lop.TEN_LOP',
                            ],
                            [
                                'attribute' => 'TONGTIEN',
                                'value' => function ($model) {
                                    return number_format($model->TONGTIEN);
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