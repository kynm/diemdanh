<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý thiết bị theo trạm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'MA_TRAM',
                            [
                                'attribute' => 'TEN_TRAM',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->TEN_TRAM;
                                }
                            ],
                            'DIADIEM',
                            [
                                'attribute' => 'ID_DAI',
                                'value' => 'iDDAI.TEN_DAIVT'
                            ],
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '#';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{view}',
                                'buttons'=>[
                                ]  
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
