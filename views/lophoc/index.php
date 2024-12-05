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

$tranghtailop = ArrayHelper::map(Trangthailophoc::find()->all(), 'MA_TRANGTHAI', 'TRANGTHAI');
$this->title = 'QUẢN LÝ LỚP';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= $this->render('/partial/_header_quanlylophoc', []) ?>
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
                                'attribute' => 'ACTION',
                                'contentOptions' => ['style' => 'width:30%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    $html = '';
                                    $html .= Html::a('</i> Điểm danh', ['lophoc/quanlydiemdanh', 'id' => $model->ID_LOP], ['class' => 'btn btn-danger btn-flat', 'data-pjax' => 0]);
                                    $html .= Html::a('<i class="fa fa-list"></i> Quản lý học sinh', ['quanlyhocsinh', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat', 'data-pjax' => 0]);
                                    $html .= Html::a('Kiểm tra', ['/chamdiem/chamdiemlophoc', 'idlophoc' => $model->ID_LOP], ['class' => 'btn btn-success btn-flat', 'data-pjax' => 0]);
                                    return $html;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_NHANVIEN_DIEMDANH',
                                'value' => 'nhanviendiemdanh.TEN_NHANVIEN',
                            ],
                            [
                                'attribute' => 'SOHOCSINH',
                                'value' => function ($model) {
                                    return number_format($model->getDshocsinh()->andWhere(['STATUS' => 1])->count());
                                }
                            ],
                            [
                                'attribute' => 'TIENHOC',
                                'value' => function ($model) {
                                    return number_format($model->TIENHOC);
                                }
                            ],
                             [
                                'attribute' => 'STATUS',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                    'filter'=> $tranghtailop,
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'options' => ['prompt' => ''],
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                'value' => function ($model) {
                                    return '<input type="checkbox" '.  ($model->STATUS ? 'checked' : '') .  ' data-id="'  . $model->ID_LOP .  '" class="doitrangthailophoc"/> ' . $model->trangthai->TRANGTHAI;
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
    $(document).on('click', '.doitrangthailophoc', function() {
        var idlop = $(this).data('id');
        var status = $(this).is(":checked") ? 1 : 0;
        $.ajax({
            url: '/lophoc/doitrangthailop',
            method: 'POST',
            data: {
                'STATUS' : status,
                'idlop' : idlop,
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