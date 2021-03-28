<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê spliter';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2 col-xs-2">
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
<h3>Tọa độ spliter trên địa bàn <span id="soluongspliter"></span></h3>
<div id="myMap" style="position:relative;width:100%px;height:1000px;"></div>
<script type='text/javascript'>
    function tinhkhoangcach(lat1,lon1,lat2,lon2) {
             var radlat1 = Math.PI * lat1/180
        var radlat2 = Math.PI * lat2/180
        var radlon1 = Math.PI * lon1/180
        var radlon2 = Math.PI * lon2/180
        var theta = lon1-lon2
        var radtheta = Math.PI * theta/180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180/Math.PI
        dist = dist * 60 * 1.1515
        if (unit=="K") { dist = dist * 1.609344 }
        if (unit=="N") { dist = dist * 0.8684 }

    alert(dist);
    };
    function GetMap() {
        var map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(20.64157486, 105.9970703)
        });
        var ID_THIETBI = $("#ID_THIETBI").val();
        var vidotb = 0;
        var kinhdotb = 0;
        if (ID_THIETBI) {
            var url = '/ioc/laydsthietbi?ID_THIETBI=' + ID_THIETBI;
                $.ajax({
                    url: url,
                    method: 'get',
                    data: {
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        var pin = null;
                        for (var i = data.length - 1; i >= 0; i--) {
                            //Add the pushpin to the map
                            pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),
                             {title: data[i].system, color: 'blue',});
                            vidotb = data[i].VIDO;
                            kinhdotb = data[i].KINHDO;
                            map.entities.push(pin);
                        }
                    }
                });            
        }
        var url = '/ioc/laydsspliter?ID_THIETBI=' + ID_THIETBI;
            $.ajax({
                url: url,
                method: 'get',
                data: {
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    var is_line = 0;
                    if (ID_THIETBI) {
                        var text = '(' + data.length + ' Spliter)';
                        $('#soluongspliter').html(text);
                        is_line = 1;
                    }
                    var line = null;
                    var pin = null;
                    for (var i = data.length - 1; i >= 0; i--) {
                        //Add the pushpin to the map
                        pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),
                         {title: data[i].TEN_KC, color: 'red',});
                        if (is_line) {
                            line = new Microsoft.Maps.Polyline([new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),new Microsoft.Maps.Location(vidotb, kinhdotb)], {strokeThickness: 5});
                            map.entities.push(line);
                            Microsoft.Maps.Events.addHandler(line, 'click', function (e) {
                                tinhkhoangcach(vidotb, kinhdotb, e.location.Latitude, e.location.longitude); 
                            });

                        }
                        map.entities.push(pin);
                    }
                }
            });
    }
</script>
<?php
$script = <<< JS
        $("#searchBtn").on( "click", function() {
            GetMap();
        });
JS;
$this->registerJs($script);
?>

