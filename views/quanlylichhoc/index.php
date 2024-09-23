<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Trangthailophoc;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ LỊCH HỌC CỐ ĐỊNH';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= $this->render('/partial/_header_quanlylichhoc', []) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'TEN_LOP',
                                'contentOptions' => ['style' => 'width:20%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Html::a($model->TEN_LOP, ['view', 'id' => $model->ID_LOP]);
                                },
                                'format' => 'raw',
                            ],
                            [
                            'attribute' => 'ds_lichcodinh',
                            'contentOptions' => ['style' => 'width:70%; white-space: normal;word-break: break-word;'],
                            'value' => function ($model) {
                                return Select2::widget([
                                    'name' => 'ds_lichcodinh' . $model->ID_LOP,
                                    'id' => 'ds_lichcodinh' . $model->ID_LOP,
                                    'value' => explode(',', $model->ds_lichcodinh),
                                    'data' => dateofmonth(),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'options' => [
                                        'placeholder' => 'Chọn ngày',
                                        'data-id' => $model->ID_LOP,
                                        'class' => 'thaydoilichhoccodinh',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => true,
                                    ],
                                ]);
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
<?php
$script = <<< JS
    $(document).on('change', '.thaydoilichhoccodinh', function() {
        var idlop = $(this).data('id');
        var ds_lichcodinh = $(this).val();
        $.ajax({
            url: '/quanlylichhoc/thaydoilichhoccodinh',
            method: 'POST',
            data: {
                'idlop' : idlop,
                'ds_lichcodinh' : ds_lichcodinh,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>