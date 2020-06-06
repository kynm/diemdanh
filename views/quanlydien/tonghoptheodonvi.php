<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

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
                        foreach ($tongdien as $key => $value): ?>
                            <?php
                            $tongthang1 += isset($value[1]) ? $value[1] : 0;
                            $tongthang2 += isset($value[2]) ? $value[2] : 0;
                            $tongthang3 += isset($value[3]) ? $value[3] : 0;
                            $tongthang4 += isset($value[4]) ? $value[4] : 0;
                            $tongthang5 += isset($value[5]) ? $value[5] : 0;
                            $tongthang6 += isset($value[6]) ? $value[6] : 0;
                            $tongthang7 += isset($value[7]) ? $value[7] : 0;
                            $tongthang8 += isset($value[8]) ? $value[8] : 0;
                            $tongthang9 += isset($value[9]) ? $value[9] : 0;
                            $tongthang10 += isset($value[10]) ? $value[10] : 0;
                            $tongthang11 += isset($value[11]) ? $value[11] : 0;
                            $tongthang12 += isset($value[12]) ? $value[12] : 0;
                            ?>
                            <tr>
                                <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                <td scope="col"><?php echo isset($value[1]) ? number_format($value[1]) : 0;?></td>
                                <td scope="col"><?php echo isset($value[2]) ? number_format($value[2]) : 0?></td>
                                <td scope="col"><?php echo isset($value[3]) ? number_format($value[3]) : 0?></td>
                                <td scope="col"><?php echo isset($value[4]) ? number_format($value[4]) : 0?></td>
                                <td scope="col"><?php echo isset($value[5]) ? number_format($value[5]) : 0?></td>
                                <td scope="col"><?php echo isset($value[6]) ? number_format($value[6]) : 0?></td>
                                <td scope="col"><?php echo isset($value[7]) ? number_format($value[7]) : 0?></td>
                                <td scope="col"><?php echo isset($value[8]) ? number_format($value[8]) : 0?></td>
                                <td scope="col"><?php echo isset($value[9]) ? number_format($value[9]) : 0?></td>
                                <td scope="col"><?php echo isset($value[10]) ? number_format($value[10]) : 0?></td>
                                <td scope="col"><?php echo isset($value[11]) ? number_format($value[11]) : 0?></td>
                                <td scope="col"><?php echo isset($value[12]) ? number_format($value[12]) : 0?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <th scope="col"><?php echo 'Tổng tiền';?></th>
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
                        foreach ($tongtram as $key => $value): ?>
                            <?php
                            $tongthang1 += isset($value[1]) ? $value[1] : 0;
                            $tongthang2 += isset($value[2]) ? $value[2] : 0;
                            $tongthang3 += isset($value[3]) ? $value[3] : 0;
                            $tongthang4 += isset($value[4]) ? $value[4] : 0;
                            $tongthang5 += isset($value[5]) ? $value[5] : 0;
                            $tongthang6 += isset($value[6]) ? $value[6] : 0;
                            $tongthang7 += isset($value[7]) ? $value[7] : 0;
                            $tongthang8 += isset($value[8]) ? $value[8] : 0;
                            $tongthang9 += isset($value[9]) ? $value[9] : 0;
                            $tongthang10 += isset($value[10]) ? $value[10] : 0;
                            $tongthang11 += isset($value[11]) ? $value[11] : 0;
                            $tongthang12 += isset($value[12]) ? $value[12] : 0;
                            ?>
                            <tr>
                                <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                <td scope="col"><?php echo isset($value[1]) ? number_format($value[1]) : 0;?></td>
                                <td scope="col"><?php echo isset($value[2]) ? number_format($value[2]) : 0?></td>
                                <td scope="col"><?php echo isset($value[3]) ? number_format($value[3]) : 0?></td>
                                <td scope="col"><?php echo isset($value[4]) ? number_format($value[4]) : 0?></td>
                                <td scope="col"><?php echo isset($value[5]) ? number_format($value[5]) : 0?></td>
                                <td scope="col"><?php echo isset($value[6]) ? number_format($value[6]) : 0?></td>
                                <td scope="col"><?php echo isset($value[7]) ? number_format($value[7]) : 0?></td>
                                <td scope="col"><?php echo isset($value[8]) ? number_format($value[8]) : 0?></td>
                                <td scope="col"><?php echo isset($value[9]) ? number_format($value[9]) : 0?></td>
                                <td scope="col"><?php echo isset($value[10]) ? number_format($value[10]) : 0?></td>
                                <td scope="col"><?php echo isset($value[11]) ? number_format($value[11]) : 0?></td>
                                <td scope="col"><?php echo isset($value[12]) ? number_format($value[12]) : 0?></td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
