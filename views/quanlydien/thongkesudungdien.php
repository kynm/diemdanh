<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê sử dụng điện theo trung tâm viễn thông';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="donvi-index">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'MA_DONVIKT',
                            'value' => 'donvitheomaketoan.TEN_DONVI',
                            'filter'=> $dsdonvi,
                        ],
                        'MA_DIENLUC',
                        [
                            'attribute' => 'THANG',
                            'filter'=> $months,
                        ],
                        [
                            'attribute' => 'NAM',
                            'filter'=> $years,
                        ],
                        [ 'attribute' =>'TIENDIEN',
                          'value' => function($model) {
                            return number_format($model->TIENDIEN, 0, ',', '.');
                          }
                        ],
                        [ 'attribute' =>'TIENTHUE',
                          'value' => function($model) {
                            return number_format($model->TIENTHUE, 0, ',', '.');
                          }
                        ],
                        [ 'attribute' =>'TONGTIEN',
                          'value' => function($model) {
                            return number_format($model->TIENTHUE, 0, ',', '.');
                          }
                        ],
                    ]
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>
