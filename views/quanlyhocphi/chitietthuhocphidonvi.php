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
                            'SO_BH',
                            'SO_BDH',
                            'SO_BN',
                            'SO_BTT',
                            'TIENHOC',
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
