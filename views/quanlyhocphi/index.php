<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Quản lý học phí';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý học phí', 'url' => ['quanlyhocphi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tạo mới', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php endif; ?>
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
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                            ],
                            [
                                'attribute' => 'TIEUDE',
                                'contentOptions' => ['style' => 'width:30%; white-space: normal;'],
                                'value' => function ($model) {
                                    return Html::a($model->TIEUDE, ['view', 'id' => $model->ID]);
                                },
                                'format' => 'raw',
                            ],
                            'TIEUDE',
                            'TU_NGAY',
                            'DEN_NGAY',
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
