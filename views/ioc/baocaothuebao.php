<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách thê bao theo thiết bị';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3 col-xs-3">
        <?= Select2::widget([
            'name' => 'THIETBI_ID',
            'id' => 'THIETBI_ID',
            'value' => $params['THIETBI_ID'] ?? 448,
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
            'value' => null,
            'data' => [],
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
</div>
<h3>Danh sách thê bao theo thiết bị <span id="thuebao"></span></h3>

<?php
$script = <<< JS
        $(document).on('change', '#THIETBI_ID', function() {
            $('#KETCUOI_ID').find('option').remove().end();
            var THIETBI_ID = $("#THIETBI_ID").val();
            var url = '/ioc/laydsspliter?THIETBI_ID=' + THIETBI_ID;
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
JS;
$this->registerJs($script);
?>