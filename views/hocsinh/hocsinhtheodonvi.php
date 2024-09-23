<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use app\models\Trangthaihocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
$tranghtaihs = ArrayHelper::map(Trangthaihocsinh::find()->all(), 'MA_TRANGTHAI', 'TRANGTHAI');

$this->title = 'QUẢN LÝ HỌC SINH';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $index, $widget, $grid){
                      return $model->SOBH_DAMUA ?  ['style'=>'color:'. colorsthuhocphi($model->SOBH_DAMUA - $model->getDsdiemdanh()->andWhere(['STATUS' => 1])->count()) .' !important;'] : [];
                    },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'ID_LOP',
                        'value' => 'lop.TEN_LOP',
                        'contentOptions' => ['style' => 'width:10%;white-space: normal;word-break: break-word;word-break: break-word'],
                        'filter'=> $dslop,
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute' => 'HO_TEN',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'value' => function($model) {
                            return Yii::$app->user->can('quanlyhocsinh') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI ? Html::a($model->HO_TEN, ['/hocsinh/lichsudiemdanh', 'id' => $model->ID], ['class' => 'text text-primary']) : '';
                        },
                        'format' => 'raw',
                    ],
                    'SO_DT',
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
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return number_format($model->TIENHOC);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SOBH_DAMUA',
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return number_format($model->SOBH_DAMUA);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SOBH_DAHOC',
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return $model->getDsdiemdanh()->andWhere(['STATUS' => 1])->count();
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'HT_HP',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'filter'=> hinhthucthuhocphi(),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'value' => function ($model) {
                            return Select2::widget([
                                'name' => 'HT_HP' . $model->ID,
                                'id' => 'HT_HP' . $model->ID,
                                'value' => $model->HT_HP,
                                'data' => hinhthucthuhocphi(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'placeholder' => 'Chọn hình thức',
                                    'data-id' => $model->ID,
                                    'class' => 'thaydoihinhthucthuhocphi',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'STATUS',
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
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
                        'class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-hocsinh')) ? '{update}{view}' : 'view'
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
    $(document).on('change', '.thaydoihinhthucthuhocphi', function() {
        var idhocsinh = $(this).data('id');
        var HT_HP = $(this).val();
        $.ajax({
            url: '/hocsinh/thaydoihinhthucthuhocphi',
            method: 'POST',
            data: {
                'HT_HP' : HT_HP,
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