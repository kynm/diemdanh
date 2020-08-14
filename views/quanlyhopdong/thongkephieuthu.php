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
<input type="hidden" name="updatedinhmucdien" id="updatedinhmucdien" value="<?= Url::to(['quanlydien/updatedinhmucdien']) ?>">
<input type="hidden" name="updatetieuthudien" id="updatetieuthudien" value="<?= Url::to(['quanlydien/updatetieuthudien']) ?>">
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
                        [
                            'attribute' => 'hopdong.MA_CSHT',
                            'value' => 'hopdong.MA_CSHT',
                        ],
                        [
                            'attribute' => 'ID_HOPDONG',
                            'value' => 'hopdong.MA_HOPDONG',
                        ],
                        'TUNGAY',
                        'DENNGAY',
                        'SOTHANG',
                        [ 'attribute' =>'GIATIEN',
                          'value' => function($model) {
                            return formatnumber($model->GIATIEN);
                          }
                        ],
                        [ 'attribute' =>'VAT',
                          'value' => function($model) {
                            return formatnumber($model->VAT);
                          }
                        ],
                        [ 'attribute' =>'TONGTIEN',
                          'value' => function($model) {
                            return formatnumber($model->TONGTIEN);
                          }
                        ],
                        'TEN_NGUOINHAN',
                        [ 'attribute' =>'TRANGTHAI',
                          'value' => function($model) {
                            return $model->TRANGTHAI ? 'Đã thanh toán' : 'Chờ thanh toán';
                          }
                        ],
                    ]
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
