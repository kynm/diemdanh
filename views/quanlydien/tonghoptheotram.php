<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổng hợp tình hình sử dụng điện trong năm của các trạm năm ' . date('Y');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tramvt-index">
<div class="box box-primary">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['baocaotonghoptheotram'],
            ]); ?>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'ID_DONVI',
                    'id' => 'ID_DONVI',
                    'value' => $params['ID_DONVI'] ?? 2,
                    'data' => $dsdonvi,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn đơn vị'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'LOAIBC',
                    'id' => 'LOAIBC',
                    'value' => $params['LOAIBC'],
                    'data' => $dmloaibc,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn tháng'],
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
                        <th scope="col">STT</th>
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
                        $i = 0;
                        foreach ($tongdien as $key => $value): ?>
                            <?php
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
                            $i++
                            ?>
                            <tr>
                                <td scope="col"><?php echo $i?></td>
                                <td scope="col"><?php echo $value['TEN_TRAM']?>
                                <br><span style="font-size: 10px;"><?php echo $value['DIADIEM']?></span>
                                    
                                </td>
                                <td scope="col"><?php echo formatnumber($value[1]);?></td>
                                <td scope="col"><?php echo formatnumber($value[2]); ?>
                                    <?php echo $value[2] - $value[1] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[2] - $value[1]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[1] - $value[2]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[3]); ?>
                                    <?php echo $value[3] - $value[2] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[3] - $value[2]) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[2] - $value[3]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[4]); ?>
                                    <?php echo $value[4] - $value[3] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[4] - $value[3]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[3] - $value[4]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[5]); ?>
                                    <?php echo $value[5] - $value[4] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[5] - $value[4]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[4] - $value[5]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[6]); ?>
                                    <?php echo $value[6] - $value[5] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[6] - $value[5]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[5] - $value[6]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[7]); ?>
                                    <?php echo $value[7] - $value[6] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[7] - $value[6]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[6] - $value[7]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[8]); ?>
                                    <?php echo $value[8] - $value[7] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[8] - $value[7]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[7] - $value[8]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[9]); ?>
                                    <?php echo $value[9] - $value[8] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[9] - $value[8]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[8] - $value[9]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[10]); ?>
                                    <?php echo $value[10] - $value[9] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[10] - $value[9]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[9] - $value[10]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[11]); ?>
                                    <?php echo $value[11] - $value[10] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[11] - $value[10]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[10] - $value[11]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[12]); ?>
                                    <?php echo $value[12] - $value[11] > 0 ? 
                                    '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($value[12] - $value[11]) : '<span class="glyphicon glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($value[11] - $value[12]);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="col" colspan="2"><?php echo 'Tổng';?></th>
                            <th scope="col"><?php echo formatnumber($tongdienthang1);?></th>
                            <th scope="col"><?php echo formatnumber($tongdienthang2);?>
                            <?php echo $tongdienthang2 - $tongdienthang1 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang2 - $tongdienthang1) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang1 - $tongdienthang2) ;
                                ?>
                                    
                                </td>
                            <th scope="col"><?php echo formatnumber($tongdienthang3);?>
                                <?php echo $tongdienthang3 - $tongdienthang2 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang3 - $tongdienthang2) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang2 - $tongdienthang3) ;
                                ?>

                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang4);?>
                                <?php echo $tongdienthang4 - $tongdienthang3 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang4 - $tongdienthang3) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang3 - $tongdienthang4) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang5);?>
                                <?php echo $tongdienthang5 - $tongdienthang4 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang5 - $tongdienthang4) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang4 - $tongdienthang5) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang6);?>
                                <?php echo $tongdienthang6 - $tongdienthang5 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang6 - $tongdienthang5) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang5 - $tongdienthang6) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang7);?>
                                <?php echo $tongdienthang7 - $tongdienthang6 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang7 - $tongdienthang6) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang6 - $tongdienthang7) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang8);?>
                                <?php echo $tongdienthang8 - $tongdienthang7 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang8 - $tongdienthang7) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang7 - $tongdienthang8) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang9);?>
                                <?php echo $tongdienthang9 - $tongdienthang8 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang9 - $tongdienthang8) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang8 - $tongdienthang9) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang10);?>
                                <?php echo $tongdienthang10 - $tongdienthang9 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang10 - $tongdienthang9) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang9 - $tongdienthang10) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang11);?>
                                <?php echo $tongdienthang11 - $tongdienthang10 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang11 - $tongdienthang10) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang10 - $tongdienthang11) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongdienthang12);?>
                                <?php echo $tongdienthang12 - $tongdienthang11 > 0 ? 
                                '<span class="glyphicon glyphicon-arrow-up btn-danger"></span>' . formatnumber($tongdienthang12 - $tongdienthang11) : '<span class="glyphicon glyphicon-arrow-down btn-success"></span>' . formatnumber($tongdienthang11 - $tongdienthang12) ;
                                ?>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

