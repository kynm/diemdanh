<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BÁO TỔNG HỢP';
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
                                <th>CHƯA THỰC HIỆN</th>
                                <th>ĐANG YÊU CẦU SỬA</th>
                                <th>ĐÃ SỬA</th>
                                <th>HOÀN THÀNH SỬA</th>
                                <th>KHÔNG CẦN SỬA</th>
                            </tr>
                            <?php
                             foreach ($baocaotonghop as $key => $value):
                                ?>
                                <tr>
                                    <td scope="col"><?php echo ($key + 1)?></td>
                                    <td scope="col"><?php echo $value['TEN_NHANVIEN']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG_NGAY']?></td>
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
