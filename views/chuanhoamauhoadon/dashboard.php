<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
$date0= date_create(date('2024-03-06'));
$date1= date_create(date('Y-m-d'));
$date2 = date_create("2023-03-25");
$diff = date_diff($date1,$date2);
$diff1 = date_diff($date1,$date0);
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'THỜI GIAN THỰC HIỆN TỬ NGÀY 06/03/2024 đến 25/03/2024. THỜI GIAN CÒN LẠI: ' . $diff->days . ' NGÀY';
?>
<div class="index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="bg-primary">
                                <th style="width: 10px">#</th>
                                <th style="text-align:center;">NHÂN VIÊN</th>
                                <th style="text-align:center;">SỐ LƯỢNG</th>
                                <th style="text-align:center;">SỐ LƯỢNG CẦN <br/>THỰC HIỆN/NGÀY</th>
                                <th style="text-align:center;">CHƯA THỰC HIỆN</th>
                                <th style="text-align:center;">ĐANG YÊU CẦU SỬA</th>
                                <th style="text-align:center;">ĐÃ SỬA</th>
                                <th style="text-align:center;">HOÀN THÀNH SỬA</th>
                                <th style="text-align:center;">KHÔNG CẦN SỬA</th>
                                <th style="text-align:center;">SỐ LƯỢNG CẦN<br/> THỰC HIỆN<br/> ĐẾN <?= date('d/m/Y')?></th>
                                <th style="text-align:center;">TỔNG HOÀN THÀNH</th>
                                <th style="text-align:center;">TỈ LỆ HOÀN THÀNH</th>
                            </tr>
                            <?php
                             foreach ($baocaotonghop as $key => $value):
                                ?>
                                <tr>
                                    <td scope="col"><?= ($key + 1)?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['TEN_NHANVIEN']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['SO_LUONG']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['SO_LUONG_NGAY']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['CHUA_TH']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['DANG_YC_SUA']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['CHUA_DA_SUA']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['HOANTHANH_SUA']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['KHONG_SUA']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $date1 < $date0 ? 0 : $value['SO_LUONG_NGAY'] * ($diff1->days + 1)?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['TONG_HOANTHANH']?></td>
                                    <td scope="col" style="font-size: 15px;"><?= $value['TI_LE']?> %</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
