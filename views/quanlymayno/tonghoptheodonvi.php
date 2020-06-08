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

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổng hợp tình hình sử dụng nhiên liệu trong năm của đơn vị năm ' . date('Y');
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">canvas{

  width:98% !important;

}</style>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" colspan="13">Số liệu sử dụng nhiên liệu trong tháng <?php echo date('m') . '/' . date('Y')?> (Giờ chạy máy nổ)</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $datasets = [];
                        foreach ($tonghoptrongthang as $key => $value): ?>
                            <?php
                            $color = $value['COLOR'];
                            $tendv = $value['TEN_DONVI'];
                            unset($value['COLOR']);
                            unset($value['TEN_DONVI']);
                            $datasets[] = [
                                'fillColor' => "red",
                                'strokeColor' => "red",
                                'pointColor' => "red",
                                'pointStrokeColor' => "red",
                                'borderColor' => $color,
                                "fill" => false,
                                "label" => $tendv,
                                'data' => $value
                            ];
                            ?>
                        <?php endforeach; ?>
                        <?php 
                        ?>
                            <tr>
                                <td colspan="12">
                                    <?= ChartJs::widget([
                                        'type' => 'line',
                                        'options' => [
                                            'height' => 100,
                                            'width' => 700
                                        ],
                                        'data' => [
                                            'labels' => $labels,
                                            'datasets' => $datasets
                                        ]
                                    ]);
                                    ?>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="13">Tổng hợp tình hình sử dụng nhiên liệu trong năm của đơn vị năm <?php echo date('Y')?> (Giờ chạy máy nổ)</th>
                    </tr>
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
                        $tongtienthang1 = 0;
                        $tongtienthang2 = 0;
                        $tongtienthang3 = 0;
                        $tongtienthang4 = 0;
                        $tongtienthang5 = 0;
                        $tongtienthang6 = 0;
                        $tongtienthang7 = 0;
                        $tongtienthang8 = 0;
                        $tongtienthang9 = 0;
                        $tongtienthang10 = 0;
                        $tongtienthang11 = 0;
                        $tongtienthang12 = 0;
                        $datasets = [];
                        foreach ($tongnhienlieu as $key => $value): ?>
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
                            $tongtienthang1 += $value[1];
                            $tongtienthang2 += $value[2];
                            $tongtienthang3 += $value[3];
                            $tongtienthang4 += $value[4];
                            $tongtienthang5 += $value[5];
                            $tongtienthang6 += $value[6];
                            $tongtienthang7 += $value[7];
                            $tongtienthang8 += $value[8];
                            $tongtienthang9 += $value[9];
                            $tongtienthang10 += $value[10];
                            $tongtienthang11 += $value[11];
                            $tongtienthang12 += $value[12];
                            ?>
                            <tr>
                                <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                <td scope="col"><?php echo formatnumber($value[1], 2);?></td>
                                <td scope="col"><?php echo formatnumber($value[2], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[3], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[4], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[5], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[6], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[7], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[8], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[9], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[10], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[11], 2); ?></td>
                                <td scope="col"><?php echo formatnumber($value[12], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng số giờ';?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang1, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang2, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang3, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang4, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang5, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang6, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang7, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang8, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang9, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang10, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang11, 2);?></th>
                                <th scope="col"><?php echo formatnumber($tongtienthang12, 2);?></th>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

