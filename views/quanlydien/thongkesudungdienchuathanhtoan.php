<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\models\Quanlydien;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cập nhật thanh toán điện';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php 
$form = ActiveForm::begin(['method' => 'get']); ?>
<div class="donvi-index">
    <div class="box box-primary">
        <div class="col-sm-12" style="margin-top: 15px">
            <?= Html::submitButton(
                '<i class="glyphicon glyphicon-link"></i> Cập nhật', 
                [
                    'class'=>'btn btn-primary btn-flat'
                ]); 
            ?>
            <?= Html::a('Kiểm tra dữ liệu lỗi', ['/quanlydien/exporttramchuamap'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showFooter' => true,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'name' => 'AddSelection'
                        ],
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
                          },
                          'footer' => formatnumber(Quanlydien::getTotal($dataProvider->models, 'TONGTIEN')),
                        ],
                        [ 'attribute' =>'IS_CHECKED',
                          'value' => function($model) {
                            return $model->IS_CHECKED ? 'Đã thanh toán' : 'Chờ thanh toán';
                          }
                        ],
                        [ 'attribute' =>'KW_TIEUTHU',
                          'value' => function($model) {
                            return formatnumber($model->KW_TIEUTHU);
                          }
                        ],
                        'THOIGIANCAPNHAT',
                    ]
                ]); ?>
            <?php Pjax::end(); ?>
        </div>

    </div>
</div>
<?php ActiveForm::end();  ?>
