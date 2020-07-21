<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê các trạm vượt định mức';
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
                        'MA_CSHT',
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
                            return formatnumber($model->TIENDIEN);
                          }
                        ],
                        [ 'attribute' =>'TIENTHUE',
                          'value' => function($model) {
                            return formatnumber($model->TIENTHUE);
                          }
                        ],
                        [ 'attribute' =>'TONGTIEN',
                          'value' => function($model) {
                            return formatnumber($model->TONGTIEN);
                          }
                        ],
                        [ 'attribute' =>'IS_CHECKED',
                          'value' => function($model) {
                            return $model->IS_CHECKED ? 'Đã thanh toán' : 'Chờ thanh toán';
                          }
                        ],
                        [ 'attribute' =>'KW_TIEUTHU',
                          'value' => function($model) {
                            return $model->KW_TIEUTHU;
                            
                          },
                          'format' => 'raw'
                        ],
                        [ 'attribute' =>'DINHMUC',
                          'value' => function($model) {
                            return formatnumber($model->DINHMUC);
                          },
                          'format' => 'raw'
                        ],
                    ]
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>
<?php
$script = <<< JS
JS;
$this->registerJs($script);

?>
