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
                            if (Yii::$app->user->can('capnhattt-qldien')) {
                                return Html::input('text', 'KW_TIEUTHU-' . $model->ID, $model->KW_TIEUTHU, ['id' => 'KW_TIEUTHU-' . $model->ID]) . Html::button('Cập nhật', ['class' => 'updatetieuthu','data-id' => $model->ID]);
                            } else {
                                return '';
                            }
                            
                          },
                          'format' => 'raw'
                        ],
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
    $(".updatetieuthu").on( "click", function() {
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var id = $(this).data('id');
        var element_tieuthu = '#KW_TIEUTHU-' + id;
        var tieuthu = $(element_tieuthu).val();
        if(intRegex.test(tieuthu) || floatRegex.test(tieuthu)) {
            var updatetieuthudien = $("#updatetieuthudien").val();
            $.ajax({
                url: updatetieuthudien + '?id=' + id,
                method: 'post',
                data: {
                    KW_TIEUTHU: tieuthu
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
                title: 'Điện tiêu thụ phải là số!',
                showConfirmButton: true
            });
        }
    });
JS;
$this->registerJs($script);

?>
