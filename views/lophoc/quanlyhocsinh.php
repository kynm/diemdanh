<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_LOP;
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
                    'MA_HOCSINH',
                    'HO_TEN',
                    'TIENHOC',
                    'DIA_CHI',
                    'SO_DT',
                    [
                        'attribute' => 'CHANGE_STATUS',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return '<input type="checkbox" '.  ($model->STATUS ? 'checked' : '') .  ' data-id="'  . $model->ID .  '" class="doitrangthaihocsinh"/> ' . $model->trangthai->TRANGTHAI;
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
    $('.doitrangthaihocsinh').on('change', function() {
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