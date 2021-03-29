<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tọa độ thuê bao trên địa bàn';
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
<h3>Tọa độ thuê bao trên địa bàn <span id="thuebao"></span></h3>
<div id="myMap" style="position:relative;width:100%px;height:1000px;"></div>
<script type='text/javascript'>
    function GetMap() {
        var map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(20.64157486, 105.9970703)
        });
        var THIETBI_ID = $("#THIETBI_ID").val();
        var KETCUOI_ID = $("#KETCUOI_ID").val();
        if (THIETBI_ID && KETCUOI_ID) {
            var url = '/ioc/laydsthuebao?THIETBI_ID=' + THIETBI_ID + '&KETCUOI_ID=' + KETCUOI_ID;
            if (KETCUOI_ID) {
                var urlspl = '/ioc/laythongtinspliter?KETCUOI_ID=' + KETCUOI_ID;
                $.ajax({
                    url: urlspl,
                    method: 'get',
                    data: {
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        var pin = null;
                        for (var i = data.length - 1; i >= 0; i--) {
                            //Add the pushpin to the map
                            pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),
                            {title: data[i].TEN_KC, color: 'red',text: 'S'});
                            map.entities.push(pin);
                        }
                    }
                });
            }
            $.ajax({
                url: url,
                method: 'get',
                data: {
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    var is_line = 0;
                    if (KETCUOI_ID) {
                        var text = '(' + data.length + ' thuê bao)';
                        $('#thuebao').html(text);
                        is_line = 1;
                    }
                    var line = null;
                    var pin = null;
                    for (var i = data.length - 1; i >= 0; i--) {
                        //Add the pushpin to the map
                        pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),
                         {title: data[i].ma_tb, color: 'blue',subTitle: 'Khoảng cách đến spliter: ' + data[i].KHOANG_CACH + ' m'});
                        map.entities.push(pin);
                    }
                }
            });            
        }
    }
</script>
<?php
$script = <<< JS
        $("#searchBtn").on( "click", function() {
             GetMap();
        });
        $("#THIETBI_ID").on( "click", function() {
            GetMap();
        });
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