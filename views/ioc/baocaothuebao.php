<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách thê bao theo thiết bị';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['baocaothuebao'],
            ]); ?>
    <div class="col-md-3 col-xs-3">
        <?= Select2::widget([
            'name' => 'ID_THIETBI',
            'id' => 'ID_THIETBI',
            'value' => $params['ID_THIETBI'] ?? 448,
            'data' => $dsthietbi,
            'theme' => Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Chọn thiết bị'],
            'pluginOptions' => [

                'allowClear' => true
            ]
        ]); ?>
    </div>
    <div class="col-md-4 col-xs-4">
        <?= Select2::widget([
            'name' => 'KETCUOI_ID',
            'id' => 'KETCUOI_ID',
            'value' => $params['KETCUOI_ID'] ?? null,
            'data' => $dsspliter,
            'theme' => Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Chọn spliter'],
            'pluginOptions' => [

                'allowClear' => true
            ]
        ]); ?>
    </div>
    <div class="col-md-2 col-xs-2">
        <?= Html::submitButton(
            '<i class="fa fa-search"></i> Xem báo cáo', 
            [
                'class'=>'btn btn-primary btn-flat',
                'id' => 'searchBtn',
                
            ])
        ?>
    </div>
<?php ActiveForm::end(); ?>
<div class="col-md-2 col-xs-2">
        <?= Html::Button(
            '<i class="fa fa-search"></i> Cập nhật khoảng cách', 
            [
                'class'=>'btn btn-primary btn-flat',
                'id' => 'capnhatkhoangcach',
                
            ])
        ?>
    </div>
</div>
<h3>Danh sách thê bao theo thiết bị <span id="thuebao"></span></h3>
 <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'KETCUOI_ID',
                        'MA_TB',
                        'TEN_DVVT',
                        'LOAIHINH_TB',
                        'TEN_TB',
                        'DIACHI_LD',
                        'KINHDO',
                        'VIDO',
                        'KHOANG_CACH',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
<?php
$script = <<< JS
        $(document).on('change', '#ID_THIETBI', function() {
            $('#KETCUOI_ID').find('option').remove().end();
            var ID_THIETBI = $("#ID_THIETBI").val();
            var url = '/ioc/laydsspliter?ID_THIETBI=' + ID_THIETBI;
            $.ajax({
                url: url,
                method: 'get',
                data: {
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    $.each(data, function(index) {
                        $('#KETCUOI_ID').append($('<option>', { value : data[index].KETCUOI_ID}).text(data[index].TEN_KC));
                    });
                }
            });
        });

        $(document).on('click', '#capnhatkhoangcach', function() {
            var KETCUOI_ID = $("#KETCUOI_ID").val();
            if (KETCUOI_ID) {
                var url = '/ioc/updatequangduongthuebao?KETCUOI_ID=' + KETCUOI_ID;
                $.ajax({
                    url: url,
                    method: 'get',
                    data: {
                    },
                    success:function(data) {
                        alert('Hoàn thành cập nhật');
                        location.reload();
                    }
                });
                } else {
                    alert('Cần chọn splter trước khi cập nhật!');
                }
            
        });
JS;
$this->registerJs($script);
?>