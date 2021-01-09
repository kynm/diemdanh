<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;
use dosamigos\chartjs\ChartJs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổng hợp tình hình sử dụng điện trong năm của đơn vị năm ' . $params['NAM'];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['baocaotonghoptheodv'],
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
                    <thead>
                      <tr>
                        <th scope="col">Tên đơn vị</th>
                        <th scope="col">Tháng 1</th>
                        <th scope="col">Tháng 2</th>
                        <th scope="col">Tháng 3</th>
                        <th scope="col">Tháng 4</th>
                        <th scope="col">Tháng 5</th>
                        <th scope="col">Tháng 6</th>
                        <th scope="col">Tháng 7</th>
                        <th scope="col">Tháng 8</th>
                        <th scope="col">Tháng 9</th>
                        <th scope="col">Tháng 10</th>
                        <th scope="col">Tháng 11</th>
                        <th scope="col">Tháng 12</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php 
                        $tongdienthang1 = 0;
                        $tongdienthang2 = 0;
                        $tongdienthang3 = 0;
                        $tongdienthang4 = 0;
                        $tongdienthang5 = 0;
                        $tongdienthang6 = 0;
                        $tongdienthang7 = 0;
                        $tongdienthang8 = 0;
                        $tongdienthang9 = 0;
                        $tongdienthang10 = 0;
                        $tongdienthang11 = 0;
                        $tongdienthang12 = 0;
                        $datasets = [];
                        foreach ($tongdien as $key => $value): ?>
                            <?php
                            $datasets[] = [
                                'fillColor' => "red",
                                'strokeColor' => "red",
                                'pointColor' => "red",
                                'pointStrokeColor' => "red",
                                'borderColor' => $value['COLOR'],
                                "fill" => false,
                                "label" => $value['TEN_DONVI'],
                                'data' => [
                                    $value[1],$value[2],$value[3],$value[4],
                                    $value[5],$value[6],$value[7],$value[8],
                                    $value[9],$value[10],$value[11],$value[12],
                                ]
                            ];
                            $tongdienthang1 += $value[1];
                            $tongdienthang2 += $value[2];
                            $tongdienthang3 += $value[3];
                            $tongdienthang4 += $value[4];
                            $tongdienthang5 += $value[5];
                            $tongdienthang6 += $value[6];
                            $tongdienthang7 += $value[7];
                            $tongdienthang8 += $value[8];
                            $tongdienthang9 += $value[9];
                            $tongdienthang10 += $value[10];
                            $tongdienthang11 += $value[11];
                            $tongdienthang12 += $value[12];
                            ?>
                            <tr>
                                <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                <td scope="col"><?php echo formatnumber($value[1]);?></td>
                                <td scope="col"><?php echo formatnumber($value[2]) . ($value[2] > $value[1]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[2] - $value[1]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[3]) . ($value[3] > $value[2]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[3] - $value[2]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[4]) . ($value[4] > $value[3]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[4] - $value[3]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[5]) . ($value[5] > $value[4]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[5] - $value[4]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[6]) . ($value[6] > $value[5]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[6] - $value[5]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[7]) . ($value[7] > $value[6]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[7] - $value[6]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[8]) . ($value[8] > $value[7]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[8] - $value[7]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[9]) . ($value[9] > $value[8]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[9] - $value[8]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[10]) . ($value[10] > $value[9]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[10] - $value[9]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[11]) . ($value[11] > $value[10]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[11] - $value[10]); ?></td>
                                <td scope="col"><?php echo formatnumber($value[12]) . ($value[12] > $value[11]? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($value[12] - $value[11]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng điện tiêu thụ';?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang1);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang2) . ($tongdienthang2 > $tongdienthang1? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang2 - $tongdienthang1);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang3) . ($tongdienthang3 > $tongdienthang2? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang3 - $tongdienthang2);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang4) . ($tongdienthang4 > $tongdienthang3? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang4 - $tongdienthang3);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang5) . ($tongdienthang5 > $tongdienthang4? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang5 - $tongdienthang4);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang6) . ($tongdienthang6 > $tongdienthang5? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang6 - $tongdienthang5);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang7) . ($tongdienthang7 > $tongdienthang6? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang7 - $tongdienthang6);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang8) . ($tongdienthang8 > $tongdienthang7? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang8 - $tongdienthang7);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang9) . ($tongdienthang9 > $tongdienthang8? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang9 - $tongdienthang8);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang10) . ($tongdienthang10 > $tongdienthang9? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang10 - $tongdienthang9);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang11) . ($tongdienthang11 > $tongdienthang10? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang11 - $tongdienthang10);?></th>
                                <th scope="col"><?php echo formatnumber($tongdienthang12) . ($tongdienthang12 > $tongdienthang11? '<span class="fa fa-angle-up btn-danger"></span>' : '<span class="fa   fa-angle-down btn-success"></span>') . formatnumber($tongdienthang12 - $tongdienthang11);?></th>
                            </tr>
                            <tr>
                                <th colspan="12">
                                    <?= ChartJs::widget([
                                        'type' => 'line',
                                        'options' => [
                                            'height' => 100,
                                            'width' => 700
                                        ],
                                        'data' => [
                                            'labels' => ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                                            'datasets' => $datasets
                                        ]
                                    ]);
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="13">TỔNG TIỀN</th>
                          </tr>
                          <tr>
                            <th >Tên đơn vị</th>
                            <th >Tháng 1</th>
                            <th >Tháng 2</th>
                            <th >Tháng 3</th>
                            <th >Tháng 4</th>
                            <th >Tháng 5</th>
                            <th >Tháng 6</th>
                            <th >Tháng 7</th>
                            <th >Tháng 8</th>
                            <th >Tháng 9</th>
                            <th >Tháng 10</th>
                            <th >Tháng 11</th>
                            <th >Tháng 12</th>
                          </tr>
                        <?php 
                        $tongthang1 = 0;
                        $tongthang2 = 0;
                        $tongthang3 = 0;
                        $tongthang4 = 0;
                        $tongthang5 = 0;
                        $tongthang6 = 0;
                        $tongthang7 = 0;
                        $tongthang8 = 0;
                        $tongthang9 = 0;
                        $tongthang10 = 0;
                        $tongthang11 = 0;
                        $tongthang12 = 0;
                        $datasets1 = [];
                        foreach ($tongtram as $key => $value): ?>
                            <?php
                            $tongthang1 += $value[1];
                            $tongthang2 += $value[2];
                            $tongthang3 += $value[3];
                            $tongthang4 += $value[4];
                            $tongthang5 += $value[5];
                            $tongthang6 += $value[6];
                            $tongthang7 += $value[7];
                            $tongthang8 += $value[8];
                            $tongthang9 += $value[9];
                            $tongthang10 +=  $value[10];
                            $tongthang11 +=  $value[11];
                            $tongthang12 +=  $value[12];
                            $datasets1[] = [
                                'fillColor' => "red",
                                'strokeColor' => "red",
                                'pointColor' => "red",
                                'pointStrokeColor' => "red",
                                'borderColor' => $value['COLOR'],
                                "fill" => false,
                                "label" => $value['TEN_DONVI'],
                                'data' => [
                                    $value[1],$value[2],$value[3],$value[4],
                                    $value[5],$value[6],$value[7],$value[8],
                                    $value[9],$value[10],$value[11],$value[12],
                                ]
                            ];
                            ?>
                            <tr>
                                <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                <td scope="col"><?php echo formatnumber($value[1]);?></td>
                                <td scope="col"><?php echo formatnumber($value[2])?></td>
                                <td scope="col"><?php echo formatnumber($value[3])?></td>
                                <td scope="col"><?php echo formatnumber($value[4])?></td>
                                <td scope="col"><?php echo formatnumber($value[5])?></td>
                                <td scope="col"><?php echo formatnumber($value[6])?></td>
                                <td scope="col"><?php echo formatnumber($value[7])?></td>
                                <td scope="col"><?php echo formatnumber($value[8])?></td>
                                <td scope="col"><?php echo formatnumber($value[9])?></td>
                                <td scope="col"><?php echo  formatnumber($value[10])?></td>
                                <td scope="col"><?php echo  formatnumber($value[11])?></td>
                                <td scope="col"><?php echo  formatnumber($value[12])?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng trạm';?></th>
                                <th scope="col"><?php echo formatnumber($tongthang1);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang2);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang3);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang4);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang5);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang6);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang7);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang8);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang9);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang10);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang11);?></th>
                                <th scope="col"><?php echo formatnumber($tongthang12);?></th>
                            </tr>
                            <tr>
                                <th colspan="12">
                                    <?= ChartJs::widget([
                                        'type' => 'line',
                                        'options' => [
                                            'height' => 100,
                                            'width' => 700
                                        ],
                                        'data' => [
                                            'labels' => ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                                            'datasets' => $datasets1
                                        ]
                                    ]);
                                    ?>
                                </th>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

