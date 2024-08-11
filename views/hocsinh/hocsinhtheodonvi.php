<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

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
                        'contentOptions' => ['style' => 'width:20%;white-space: normal;word-break: break-word;word-break: break-word'],
                        'filter'=> $dslop,
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    'HO_TEN',
                    'SO_DT',
                    'NGAY_BD',
                    'NGAY_KT',
                    'TIENHOC',
                    'SOBH_DAMUA',
                    [
                        'attribute' => 'SOBH_DAHOC',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return $model->getDsdiemdanh()->andWhere(['STATUS' => 1])->count();
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'CHANGE_STATUS',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
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
JS;
$this->registerJs($script);
?>