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
<input type="hidden" name="urluploadimage" id="updatedinhmucdien" value="<?= Url::to(['quanlydien/updatedinhmucdien']) ?>">
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
                            return number_format($model->TONGTIEN, 0, ',', '.');
                          }
                        ],
                        'KW_TIEUTHU',
                        [ 'attribute' =>'DINHMUC',
                          'value' => function($model) {
                            if (Yii::$app->user->can('capnhatdinhmuc-qldien')) {
                                return Html::input('text', 'DINHMUC-' . $model->ID, $model->DINHMUC, ['id' => 'DINHMUC-' . $model->ID]) . Html::button('Cập nhật', ['class' => 'updatedinhmuc','data-id' => $model->ID]);
                            } else {
                                return '';
                            }
                            
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
    $(".updatedinhmuc").on( "click", function() {
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var id = $(this).data('id');
        var element_dinhmuc = '#DINHMUC-' + id;
        var dinhmuc = $(element_dinhmuc).val();
        if(intRegex.test(dinhmuc) || floatRegex.test(dinhmuc)) {
            var updatedinhmucdien = $("#updatedinhmucdien").val();
            $.ajax({
                url: updatedinhmucdien + '?id=' + id,
                method: 'post',
                data: {
                    DINHMUC: dinhmuc
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if(data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Định mức phải là số!',
                showConfirmButton: true
            });
        }
    });
JS;
$this->registerJs($script);

?>
