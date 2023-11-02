<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
$date0= date_create(date('2023-11-03'));
$date1= date_create(date('Y-m-d'));
$date2 = date_create("2023-12-03");
$diff = date_diff($date1,$date2);
$diff1 = date_diff($date0,$date1);
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'THỜI GIAN THỰC HIỆN TỬ NGÀY 03/11/2023 đến 03/12/2023. THỜI GIAN CÒN LẠI: ' . $diff->days . ' NGÀY';
?>
<div class="index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NHÂN VIÊN</th>
                                <th>SỐ LƯỢNG</th>
                                <th>SỐ LƯỢNG CẦN THỰC HIỆN/NGÀY</th>
                                <th>SỐ LƯỢNG CẦN THỰC HIỆN ĐẾN HÔM NAY</th>
                                <th>CHƯA THỰC HIỆN</th>
                                <th>ĐANG YÊU CẦU SỬA</th>
                                <th>ĐÃ SỬA</th>
                                <th>HOÀN THÀNH SỬA</th>
                                <th>KHÔNG CẦN SỬA</th>
                                <th>TỈ LỆ HOÀN THÀNH</th>
                            </tr>
                            <?php
                             foreach ($baocaotonghop as $key => $value):
                                ?>
                                <tr>
                                    <td scope="col"><?php echo ($key + 1)?></td>
                                    <td scope="col"><?php echo $value['TEN_NHANVIEN']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG_NGAY']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG_NGAY'] * ($diff->days + 1)?></td>
                                    <td scope="col"><?php echo $value['CHUA_TH']?></td>
                                    <td scope="col"><?php echo $value['DANG_YC_SUA']?></td>
                                    <td scope="col"><?php echo $value['CHUA_DA_SUA']?></td>
                                    <td scope="col"><?php echo $value['HOANTHANH_SUA']?></td>
                                    <td scope="col"><?php echo $value['KHONG_SUA']?></td>
                                    <td scope="col"><?php echo $value['TI_LE']?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
