<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổng hợp tình hình sử dụng điện nhiên liệu trong năm của các trạm năm ' . date('Y');
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
                <label>Xuất excel</label>
                <input type="checkbox" name="is_excel" value="1">
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
                        <th scope="col">Tổng</th>
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
                        $i = 0;
                        foreach ($data as $key => $value): ?>
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
                            $tongthang10 += $value[10];
                            $tongthang11 += $value[11];
                            $tongthang12 += $value[12];
                            $i++
                            ?>
                            <tr>
                                <td scope="col"><?php echo $i?></td>
                                <td scope="col"><?php echo $value['TEN_TRAM']?>
                                <br><span style="font-size: 10px;"><?php echo $value['DIADIEM']?></span>
                                    
                                </td>
                                <td scope="col"><?php echo formatnumber($value[1], 2);?></td>
                                <td scope="col"><?php echo formatnumber($value[2], 2); ?>
                                    <?php echo $value[2] - $value[1] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[2] - $value[1]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[1] - $value[2]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[3], 2); ?>
                                    <?php echo $value[3] - $value[2] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[3] - $value[2]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[2] - $value[3]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[4], 2); ?>
                                    <?php echo $value[4] - $value[3] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[4] - $value[3]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[3] - $value[4]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[5], 2); ?>
                                    <?php echo $value[5] - $value[4] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[5] - $value[4]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[4] - $value[5]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[6], 2); ?>
                                    <?php echo $value[6] - $value[5] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[6] - $value[5]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[5] - $value[6]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[7], 2); ?>
                                    <?php echo $value[7] - $value[6] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[7] - $value[6]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[6] - $value[7]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[8], 2); ?>
                                    <?php echo $value[8] - $value[7] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[8] - $value[7]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[7] - $value[8]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[9], 2); ?>
                                    <?php echo $value[9] - $value[8] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[9] - $value[8]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[8] - $value[9]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[10], 2); ?>
                                    <?php echo $value[10] - $value[9] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[10] - $value[9]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[9] - $value[10]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[11], 2); ?>
                                    <?php echo $value[11] - $value[10] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[11] - $value[10]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[10] - $value[11]);
                                    ?>
                                </td>
                                <td scope="col"><?php echo formatnumber($value[12], 2); ?>
                                    <?php echo $value[12] - $value[11] > 0 ? 
                                    '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($value[12] - $value[11]) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($value[11] - $value[12]);
                                    ?>
                                </td>
                                <td scope="col">
                                    <?php echo $value[1] + $value[2] + $value[3] + $value[4] + $value[5] + $value[6] + $value[7] + $value[8] + $value[9] + $value[10] + $value[11] + $value[12];
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="col" colspan="2"><?php echo 'Tổng';?></th>
                            <th scope="col"><?php echo formatnumber($tongthang1);?></th>
                            <th scope="col"><?php echo formatnumber($tongthang2);?>
                            <?php echo $tongthang2 - $tongthang1 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang2 - $tongthang1) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang1 - $tongthang2) ;
                                ?>
                                    
                                </td>
                            <th scope="col"><?php echo formatnumber($tongthang3);?>
                                <?php echo $tongthang3 - $tongthang2 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang3 - $tongthang2) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang2 - $tongthang3) ;
                                ?>

                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang4);?>
                                <?php echo $tongthang4 - $tongthang3 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang4 - $tongthang3) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang3 - $tongthang4) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang5);?>
                                <?php echo $tongthang5 - $tongthang4 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang5 - $tongthang4) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang4 - $tongthang5) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang6);?>
                                <?php echo $tongthang6 - $tongthang5 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang6 - $tongthang5) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang5 - $tongthang6) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang7);?>
                                <?php echo $tongthang7 - $tongthang6 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang7 - $tongthang6) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang6 - $tongthang7) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang8);?>
                                <?php echo $tongthang8 - $tongthang7 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang8 - $tongthang7) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang7 - $tongthang8) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang9);?>
                                <?php echo $tongthang9 - $tongthang8 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang9 - $tongthang8) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang8 - $tongthang9) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang10);?>
                                <?php echo $tongthang10 - $tongthang9 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang10 - $tongthang9) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang9 - $tongthang10) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang11);?>
                                <?php echo $tongthang11 - $tongthang10 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang11 - $tongthang10) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang10 - $tongthang11) ;
                                ?>
                            </th>
                            <th scope="col"><?php echo formatnumber($tongthang12);?>
                                <?php echo $tongthang12 - $tongthang11 > 0 ? 
                                '<span class="fa fa-angle-up btn-danger"></span>' . formatnumber($tongthang12 - $tongthang11) : '<span class="fa   fa-angle-down btn-success"></span>' . formatnumber($tongthang11 - $tongthang12) ;
                                ?>
                            </th>
                            <th>
                                <?php echo $tongthang1 + $tongthang2 + $tongthang3 + $tongthang4 + $tongthang5 + $tongthang6 + $tongthang7 + $tongthang8 + $tongthang9 + $tongthang10 + $tongthang11 + $tongthang12
                                    ?>

                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
