<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use dosamigos\chartjs\ChartJs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổng hợp tình hình sử dụng điện trong năm của đơn vị năm ' . $params['NAM'] . ' so với năm ' . ($params['NAM'] - 1) . ' theo KW sử dụng';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['baocaocungky'],
            ]); ?>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'NAM',
                    'id' => 'NAM',
                    'value' => $params['NAM'],
                    'data' => $years,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn năm'],
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
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <?php
                        foreach ($tongdien as $key => $value): ?>
                            <?php
                            // echo "<pre>";
                            // die(var_dump($value['DATANOW']));
                            $datasets= [];
                            $datasets[] = [
                                'label' => ($params['NAM'] - 2),
                                'data' => [$value['DATAOLDOLD'][1],$value['DATAOLDOLD'][2],$value['DATAOLDOLD'][3],$value['DATAOLDOLD'][4],$value['DATAOLDOLD'][5],$value['DATAOLDOLD'][6],$value['DATAOLDOLD'][9],$value['DATAOLDOLD'][8],$value['DATAOLDOLD'][9],$value['DATAOLDOLD'][10],$value['DATAOLDOLD'][11],$value['DATAOLDOLD'][12]],
                                'backgroundColor' => 'gray',
                                'borderColor' => 'gray',
                            ];
                            $datasets[] = [
                                'label' => ($params['NAM'] - 1),
                                'data' => [$value['DATAOLD'][1],$value['DATAOLD'][2],$value['DATAOLD'][3],$value['DATAOLD'][4],$value['DATAOLD'][5],$value['DATAOLD'][6],$value['DATAOLD'][9],$value['DATAOLD'][8],$value['DATAOLD'][9],$value['DATAOLD'][10],$value['DATAOLD'][11],$value['DATAOLD'][12]],
                                'backgroundColor' => '#3c8dbc',
                                'borderColor' => '#3c8dbc',
                            ];
                            $datasets[] = [
                                'label' => $params['NAM'],
                                'data' => [$value['DATANOW'][1],$value['DATANOW'][2],$value['DATANOW'][3],$value['DATANOW'][4],$value['DATANOW'][5],$value['DATANOW'][6],$value['DATANOW'][9],$value['DATANOW'][8],$value['DATANOW'][9],$value['DATANOW'][10],$value['DATANOW'][11],$value['DATANOW'][12]],
                                'backgroundColor' => '#3cbc7e',
                                'borderColor' => '#3cbc7e',
                            ];
                            ?>
                        <tr>
                            <th colspan="12" style="text-align: center; font-size: 20px;font-weight: bold;">
                                <?php echo $value["TEN_DONVI"]?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="12">
                                <?= ChartJs::widget([
                                    'type' => 'bar',
                                    'options' => [],
                                    'data' => [
                                        'labels' => ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
                                        'datasets' => $datasets
                                    ]
                                ]);
                                ?>
                            </th>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

