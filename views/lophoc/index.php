<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ LỚP';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= (Yii::$app->user->can('create-lophoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm lớp học', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
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
                                'contentOptions' => ['style' => 'width:40%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return Html::a($model->TEN_LOP, ['view', 'id' => $model->ID_LOP]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOHOCSINH',
                                'value' => function ($model) {
                                    return $model->getDshocsinh()->count();
                                }
                            ],
                            'TIENHOC',
                             [
                                'attribute' => 'CHANGE_STATUS',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
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
    $('.doitrangthailophoc').on('change', function() {
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