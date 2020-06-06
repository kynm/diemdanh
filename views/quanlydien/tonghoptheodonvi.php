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

$this->title = 'Tổng hợp tình hình sử dụng điện trong năm của đơn vị năm ' . date('Y');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tramvt-index">
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
                                <td scope="col"><?php echo number_format($value[1]);?></td>
                                <td scope="col"><?php echo number_format($value[2]); ?></td>
                                <td scope="col"><?php echo number_format($value[3]); ?></td>
                                <td scope="col"><?php echo number_format($value[4]); ?></td>
                                <td scope="col"><?php echo number_format($value[5]); ?></td>
                                <td scope="col"><?php echo number_format($value[6]); ?></td>
                                <td scope="col"><?php echo number_format($value[7]); ?></td>
                                <td scope="col"><?php echo number_format($value[8]); ?></td>
                                <td scope="col"><?php echo number_format($value[9]); ?></td>
                                <td scope="col"><?php echo number_format($value[10]); ?></td>
                                <td scope="col"><?php echo number_format($value[11]); ?></td>
                                <td scope="col"><?php echo number_format($value[12]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng tiền';?></th>
                                <th scope="col"><?php echo number_format($tongtienthang1);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang2);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang3);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang4);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang5);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang6);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang7);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang8);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang9);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang10);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang11);?></th>
                                <th scope="col"><?php echo number_format($tongtienthang12);?></th>
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
                                <th colspan="13">Danh sách trạm phát sinh</th>
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
                                <td scope="col"><?php echo number_format($value[1]);?></td>
                                <td scope="col"><?php echo number_format($value[2])?></td>
                                <td scope="col"><?php echo number_format($value[3])?></td>
                                <td scope="col"><?php echo number_format($value[4])?></td>
                                <td scope="col"><?php echo number_format($value[5])?></td>
                                <td scope="col"><?php echo number_format($value[6])?></td>
                                <td scope="col"><?php echo number_format($value[7])?></td>
                                <td scope="col"><?php echo number_format($value[8])?></td>
                                <td scope="col"><?php echo number_format($value[9])?></td>
                                <td scope="col"><?php echo  number_format($value[10])?></td>
                                <td scope="col"><?php echo  number_format($value[11])?></td>
                                <td scope="col"><?php echo  number_format($value[12])?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng trạm';?></th>
                                <th scope="col"><?php echo number_format($tongthang1);?></th>
                                <th scope="col"><?php echo number_format($tongthang2);?></th>
                                <th scope="col"><?php echo number_format($tongthang3);?></th>
                                <th scope="col"><?php echo number_format($tongthang4);?></th>
                                <th scope="col"><?php echo number_format($tongthang5);?></th>
                                <th scope="col"><?php echo number_format($tongthang6);?></th>
                                <th scope="col"><?php echo number_format($tongthang7);?></th>
                                <th scope="col"><?php echo number_format($tongthang8);?></th>
                                <th scope="col"><?php echo number_format($tongthang9);?></th>
                                <th scope="col"><?php echo number_format($tongthang10);?></th>
                                <th scope="col"><?php echo number_format($tongthang11);?></th>
                                <th scope="col"><?php echo number_format($tongthang12);?></th>
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

