<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Trangthaihocsinh;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
$tranghtaihs = ArrayHelper::map(Trangthaihocsinh::find()->all(), 'MA_TRANGTHAI', 'TRANGTHAI');

$this->title = $model->TEN_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $model,]) ?>
</div>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
<div class="daivt-view">
    <?= $this->render('_form_hocsinh', ['model' => $hocsinh, 'id' => $model->ID_LOP]) ?>
</div>
<?php endif; ?>
<div class="box box-primary">
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'STATUS',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'filter'=> $tranghtaihs,
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'value' => function ($model) {
                            return '<input type="checkbox" '.  ($model->STATUS ? 'checked' : '') .  ' data-id="'  . $model->ID .  '" class="doitrangthaihocsinh"/> ' . $model->trangthai->TRANGTHAI;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'HO_TEN',
                        'value' => function($model) {
                            return Yii::$app->user->can('quanlyhocsinh') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI ? Html::a($model->HO_TEN, ['/hocsinh/lichsudiemdanh', 'id' => $model->ID], ['class' => 'text text-primary']) : '';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'NGAY_SINH',
                        'value' => function($model) {
                            return $model->NGAY_SINH ? Yii::$app->formatter->asDatetime($model->NGAY_SINH, 'php:d/m/Y') : NULL;
                        },
                    ],
                    [
                        'attribute' => 'NGAY_BD',
                        'value' => function($model) {
                            return $model->NGAY_BD ? Yii::$app->formatter->asDatetime($model->NGAY_BD, 'php:d/m/Y') : NULL;
                        },
                    ],
                    [
                        'attribute' => 'NGAY_KT',
                        'value' => function($model) {
                            return $model->NGAY_KT ? Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y') : NULL;
                        },
                    ],
                    [
                        'attribute' => 'TIENHOC',
                        'value' => function($model) {
                            return '<input class="form-control capnhattienhoc" type="number" data-id="' . $model->ID . '" value="' . $model->TIENHOC . '" placeholder="TIỀN HỌC">';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'DIA_CHI',
                        'value' => function($model) {
                            return '<input class="form-control capnhatdiachi" type="text" data-id="' . $model->ID . '" value=" ' . $model->DIA_CHI . '" placeholder="ĐỊA CHỈ">';
                        },
                        'format' => 'raw',
                    ],
                    'SO_DT',
                    [
                        'attribute' => '',
                        'value' => function($model) {
                            return Yii::$app->user->can('quanlyhocsinh') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI ? Html::a('<i class="fa fa-pencil-square-o"></i> Chỉnh sửa', ['/hocsinh/update', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) : '';
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
$script = <<< JS
    $(document).on('click', '.doitrangthaihocsinh', function() {
        var idhocsinh = $(this).data('id');
        var status = $(this).is(":checked") ? 1 : 0;
        $.ajax({
            url: '/hocsinh/doitrangthailop',
            method: 'POST',
            data: {
                'STATUS' : status,
                'idhocsinh' : idhocsinh,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire(data.message);
                }
                setTimeout(() => {
                    window.location.reload(true);
                }, 1000);
            }
        });
    });

    $(document).on('change', '.capnhatdiachi', function() {
        var idhocsinh = $(this).data('id');
        var diachi = $(this).val();
        $.ajax({
            url: '/hocsinh/capnhatdiachihocsinh',
            method: 'POST',
            data: {
                'tienhoc' : tienhoc,
                'idhocsinh' : idhocsinh,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });
    $(document).on('change', '.capnhattienhoc', function() {
        var idhocsinh = $(this).data('id');
        var tienhoc = $(this).val();
        $.ajax({
            url: '/hocsinh/capnhattienhoc',
            method: 'POST',
            data: {
                'TIENHOC' : tienhoc,
                'idhocsinh' : idhocsinh,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire(data.message);
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>