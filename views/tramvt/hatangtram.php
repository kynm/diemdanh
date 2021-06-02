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
                        // 'options' => [
                        //     'class' => 'table-responsive',
                        // ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'MA_CSHT',
                            [
                                'attribute' => 'TEN_TRAM',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->TEN_TRAM, Url::to(['tramvt/view', 'id' => $model->ID_TRAM]));
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
                                    return $model->iDNHANVIEN ? Html::a($model->iDNHANVIEN->TEN_NHANVIEN, Url::to(['nhanvien/view', 'id' => $model->ID_NHANVIEN])) : '#';
                                }
                            ],
                            [
                                'attribute' => 'LOAITRAM',
                                'value' => 'loaihinhcsht.TEN_LOAIHINH_CSHT'
                            ],
                            [
                                'attribute' => 'TRANGTHAI_CSHT_ID',
                                'value' => 'trangthaicsht.TEN_TRANGTHAI_CSHT'
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
